@extends('adminlte::page')

@section('title', 'AI Analyzer')

@section('content_header')
    <h1>AI Image Analyzer</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="upload-form" method="POST" action="{{ route('ai.analyze') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="images">Upload Images</label>
                    <div id="drop-area" class="border border-dashed border-2 rounded p-4 text-center bg-light">
                        <p>Drag & Drop images here or click to select</p>
                        <input type="file" id="images" name="images[]" multiple hidden>
                        <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('images').click();">
                            Select Images
                        </button>
                        <div id="file-list" class="mt-3"></div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3">Analyze</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
<script>
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('images');
    const fileList = document.getElementById('file-list');

    dropArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropArea.classList.add('bg-primary', 'text-white');
    });

    dropArea.addEventListener('dragleave', () => {
        dropArea.classList.remove('bg-primary', 'text-white');
    });

    dropArea.addEventListener('drop', (e) => {
        e.preventDefault();
        dropArea.classList.remove('bg-primary', 'text-white');
        fileInput.files = e.dataTransfer.files;
        showFileList(fileInput.files);
    });

    fileInput.addEventListener('change', () => {
        showFileList(fileInput.files);
    });

    function showFileList(files) {
        fileList.innerHTML = '';
        Array.from(files).forEach(file => {
            const p = document.createElement('p');
            p.textContent = file.name;
            fileList.appendChild(p);
        });
    }
</script>
@endsection
