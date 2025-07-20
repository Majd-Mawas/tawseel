@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
    <div class="signin-form">
        <div class="form-heading">Reset Password</div>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                    value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="submit">
                Send Password Reset Link
            </button>

            <div class="form-footer">
                <a href="{{ route('login') }}">Back to Login</a>
            </div>
        </form>
    </div>
@endsection
