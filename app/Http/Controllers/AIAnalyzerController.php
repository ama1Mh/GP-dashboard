<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AIAnalyzerController extends Controller
{
    public function index()
    {
        return view('ai.index');
    }

    public function predict(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120|mimes:jpg,jpeg,png',
        ]);

        try {
            $image = $request->file('image');

            // اختياري: تحميل الصورة إلى imgbb فقط لأغراض العرض لاحقًا
            $imageUrl = $this->uploadImage($image);

            // تحليل الصورة باستخدام Roboflow
            $analysis = $this->analyzeWithRoboflow($image);

            // التعامل مع النتائج
            return $this->handleAnalysisResults($imageUrl, $analysis);

        } catch (\Exception $e) {
            Log::error('AI Analysis Failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    private function uploadImage($image)
    {
        $response = Http::asForm()->post('https://api.imgbb.com/1/upload', [
            'key' => config('services.imgbb.key'),
            'image' => base64_encode(file_get_contents($image->getRealPath()))
        ]);

        if (!$response->successful()) {
            throw new \Exception("Image hosting failed: " . $response->body());
        }

        return $response->json('data.url');
    }

    private function analyzeWithRoboflow($image)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.roboflow.key'),
            'Accept' => 'application/json',
        ])->timeout(30)->post('https://api.roboflow.com/' . config('services.roboflow.workflow_id'), [
            'image' => [
                'type' => 'base64',
                'value' => base64_encode(file_get_contents($image->getRealPath()))
            ],
            'workspace' => config('services.roboflow.workspace'),
            'top_class' => 'unknown',
            'active_learning' => true
        ]);

        if ($response->status() === 403) {
            $this->requestPermissionUpgrade();
            throw new \Exception("Insufficient permissions. Admin access required for this workflow.");
        }

        if ($response->failed()) {
            throw new \Exception("Roboflow API Error: " . $response->body());
        }

        Log::info('Roboflow response:', $response->json()); // لمساعدتك في الديبق

        return $response->json();
    }

    private function handleAnalysisResults($imageUrl, $analysis)
    {
        if (empty($analysis['predictions'])) {
            throw new \Exception("لم يتم اكتشاف أي كائن في الصورة. تأكد من وضوح الصورة وأنها تحتوي على كائنات تعرفها النموذج.");
        }

        return redirect()->route('ai.report')->with([
            'results' => [
                'image_url' => $imageUrl,
                'predictions' => $analysis['predictions'],
                'top_class' => $analysis['top_class'] ?? 'unknown',
                'confidence' => $analysis['confidence'] ?? null,
                'upload_status' => $analysis['roboflow_dataset_upload'] ?? null
            ]
        ]);
    }

    private function requestPermissionUpgrade()
    {
        try {
            Mail::raw('Permission upgrade needed for Roboflow workflow', function ($message) {
                $message->to(config('services.roboflow.admin_email'))
                        ->subject('API Access Request');
            });
        } catch (\Exception $e) {
            Log::error('Permission request failed: ' . $e->getMessage());
        }
    }

    public function report()
    {
        if (!session()->has('results')) {
            return redirect()->route('ai.index');
        }

        return view('ai.report', [
            'results' => session('results')
        ]);
    }
}
