<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class AIAnalyzerController extends Controller
{
    public function index()
    {
        return view('ai.index');
    }

    public function analyze(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240'
        ]);
    
        $results = [];
    
        foreach ($request->file('images') as $image) {
            // 1. خزّن الصورة
            $path = $image->store('uploads', 'public');
    
            // 2. شغّل الذكاء الاصطناعي (بشكل مبسط مثال)
            // استبدل السطر الجاي بمناداة نموذجك الحقيقي
            $aiResult = $this->mockAIResult($path); 
    
            // 3. خزّن النتيجة لكل صورة
            $results[] = [
                'image' => $path,
                'result' => $aiResult
            ];
        }
    
        // 4. رجعهم لصفحة التقرير
        return view('ai-report', compact('results'));
    }
    
    // نموذج وهمي (تستبدله بـ AI حقيقي لاحقًا)
    private function mockAIResult($path)
    {
        $classes = ['Garbage', 'Tree', 'People', 'Street Light', 'Car'];
        $random = collect($classes)->random(rand(1, 3));
        return 'Detected: ' . $random->implode(', ');
    }
    
}

