@extends('adminlte::page')

@section('title', 'AI Report')

@section('content_header')
    <h1>Analysis Report</h1>
@endsection

@section('content')
    <div class="row">
        @foreach ($results as $res)
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="{{ asset('storage/' . $res['image']) }}" class="card-img-top" alt="Image" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <p class="card-text">{{ $res['result'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
