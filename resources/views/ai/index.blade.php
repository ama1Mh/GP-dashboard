@extends('adminlte::page')

@section('title', 'AI Image Analyzer')

@section('content_header')
    <h1>Upload Image(s) for Analysis</h1>
@stop

@section('content')
    <form action="{{ route('ai.analyze') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="images" class="form-label">Upload Image(s)</label>
            <input class="form-control" type="file" name="images[]" multiple required>
        </div>
        <button type="submit" class="btn btn-primary">Analyze</button>
    </form>
@stop
