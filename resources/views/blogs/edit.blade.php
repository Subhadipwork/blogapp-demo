@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <h1 class="text-center">Edit Blog Post</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="POST" action="{{ route('blogs.update', $blog->id) }}">
                @csrf
                @method('PUT')

                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Enter blog title" required autofocus value="{{ $blog->title }}" />
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="content" class="form-control" placeholder="Enter blog description">{{ $blog->content }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Update Blog Post</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#description'))
        .catch(error => {
            console.error(error);
        });
</script>
@endpush