@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    @auth
                    {{ auth()->user()->name }} {{ __('You are logged in!') }}
                    <hr>
                    @endauth
                    <h3 class="text-center">Blog Posts</h3>
                    @foreach($blogs as $blog)
                    <hr>
                    <div class="blog-card mb-3">
                        <div class="blog-header">
                            <h4>{{ $blog->title }}</h4>
                            <p>Author: {{ $blog->user->name }}</p>
                        </div>
                        <div class="blog-content">
                            <p>{!! $blog->content !!}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection