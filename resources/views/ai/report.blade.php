@extends('adminlte::page')

@section('title', 'AI Analysis Report')

@section('content')
<div class="container">
    <h1 class="mb-4">AI Analysis Report</h1>

    <h1>Prediction Results</h1>

@foreach($results as $result)
    <h3>{{ $result['original_name'] }}</h3>
    <pre>{{ is_array($result['result']) ? json_encode($result['result'], JSON_PRETTY_PRINT) : $result['result'] }}</pre>
@endforeach

<a href="{{ route('ai.index') }}">Analyze Another Image</a>

</div>
@endsection
