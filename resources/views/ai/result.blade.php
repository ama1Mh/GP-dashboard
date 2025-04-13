@extends('adminlte::page')

@section('title', 'AI Results')

@section('content_header')
    <h1>Analysis Report</h1>
@stop

@section('content')
    @foreach($results as $res)
        <div class="card my-3">
            <div class="card-body">
                <img src="{{ asset($res['path']) }}" style="max-width: 300px;">
                <h5 class="mt-3">{{ $res['filename'] }}</h5>
                <p><strong>Result:</strong> {{ $res['result'] }}</p>
            </div>
        </div>
    @endforeach
@stop
