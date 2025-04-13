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
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $results = [];

        foreach ($request->file('images') as $image) {
            $path = $image->store('uploads', 'public');

            // 👇 Run the image through the AI model (this is just a placeholder)
            $output = $this->runModel(public_path("storage/" . $path));

            $results[] = [
                'filename' => $image->getClientOriginalName(),
                'result' => $output,
                'path' => "storage/" . $path,
            ];
        }

        return view('ai.result', compact('results'));
    }

    // 👇 Dummy function (replace this with real model code later)
    private function runModel($imagePath)
    {
        // Call Python script or use PHP-Python bridge
        return "Garbage detected in the area"; // Replace with real result
    }
}

