@extends('adminlte::page')

@section('title', 'AI Analyzer')

@section('content_header')
    <h1>AI Image Analyzer</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
        <form action="{{ route('ai.analyze') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="image">Choose an image:</label>
    <input type="file" name="image" id="image" required>
    <button type="submit">Analyze</button>
</form>

@if ($errors->any())
    <div style="color: red">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    </div>
@endsection
