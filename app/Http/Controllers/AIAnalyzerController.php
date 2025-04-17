<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class AIAnalyzerController extends Controller
{
    public function index()
    {
        return view('ai.index');
    }

    public function predict(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120',
        ]);

        $image = $request->file('image');
        $path = $image->store('temp');
        $localPath = storage_path("app/{$path}");

        // Upload to imgbb
        $imgbbApiKey = config('services.imgbb.key');
        $base64Image = base64_encode(file_get_contents($localPath));

        $imgbbResponse = Http::asForm()->post("https://api.imgbb.com/1/upload", [
            'key' => $imgbbApiKey,
            'image' => $base64Image,
        ]);
        

        Storage::delete($path); // delete local file

        if (!$imgbbResponse->ok() || !isset($imgbbResponse['data']['url'])) {
            return back()->withErrors(['image' => 'Image upload failed.']);
        }

        $imageUrl = $imgbbResponse['data']['url'];

        // Send to Roboflow
        $roboflowResult = $this->analyzeWithRoboflow($imageUrl);

        // Store and redirect
        return redirect()->route('ai.report')->with([
            'results' => [[
                'original_name' => $image->getClientOriginalName(),
                'result' => $roboflowResult
            ]]
        ]);
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

    private function analyzeWithRoboflow($imageUrl)
    {
        $apiKey = config('services.roboflow.key');
        $url = "https://serverless.roboflow.com/gpmodel/1?api_key={$apiKey}&image=" . urlencode($imageUrl);

        try {
            $response = Http::post($url);

            if ($response->failed()) {
                \Log::error('Roboflow API Error', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return "API Error (HTTP {$response->status()}): " .
                       ($response->json()['error'] ?? $response->body());
            }

            return $this->formatPredictionResults($response->json());

        } catch (\Exception $e) {
            \Log::error('Roboflow Connection Error', [
                'error' => $e->getMessage()
            ]);
            return "Connection Error: " . $e->getMessage();
        }
    }

    private function formatPredictionResults($response)
    {
        if (!isset($response['predictions']) || empty($response['predictions'])) {
            return 'No objects detected.';
        }

        $summary = [];

        foreach ($response['predictions'] as $prediction) {
            $class = $prediction['class'];
            $summary[$class] = ($summary[$class] ?? 0) + 1;
        }

        return $summary;
    }
}
