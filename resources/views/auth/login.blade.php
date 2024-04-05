@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <h1 class="text-center">Login</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="POST" action="{{ route('login') }}">
                @csrf

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
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email"  autofocus value="{{ old('email') }}" />
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password"  />
                </div>

                <div class="mb-3 form-check">
                 
                </div>

                <button type="submit" class="btn btn-primary btn-block">Sign in</button>
            </form>
            <div class="text-center mt-3">
                <p>Not a member? <a href="{{ route('register') }}">Register</a></p>
            </div>
        </div>
    </div>
</div>

@endsection