@extends('adminlte::page')

@section('title', 'AI Analysis Report')

@section('content')
<div class="container">
<div class="mb-4">
    <h3>Analyzed Image</h3>
    <img src="{{ $results['image_url'] }}" class="img-fluid mb-3" alt="Analyzed Image">

    <h4>Top Class: {{ $results['top_class'] ?? 'N/A' }}</h4>
    <p>Confidence: {{ $results['confidence'] ?? 'N/A' }}</p>

    @if (!empty($results['predictions']) && is_array($results['predictions']))
        <h4>Predictions:</h4>
        <ul>
            @foreach ($results['predictions'] as $prediction)
                <li>
                    Class: {{ $prediction['class'] ?? 'N/A' }} |
                    Confidence: {{ $prediction['confidence'] ?? 'N/A' }}
                </li>
            @endforeach
        </ul>
    @else
        <p>No predictions found for this image.</p>
    @endif

    @if (!empty($results['upload_status']['message']))
        <p><strong>Upload Status:</strong> {{ $results['upload_status']['message'] }}</p>
    @endif
</div>

<a href="{{ route('ai.index') }}" class="btn btn-primary">Analyze Another Image</a>

</div>
@endsection
