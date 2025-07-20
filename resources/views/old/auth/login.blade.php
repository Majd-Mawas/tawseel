@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <form class="signin-form" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-heading">SIGN IN</div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="input-group">
            <label class="label" for="email">Email</label>
            <input required placeholder="Enter your email" name="email" id="email" type="email"
                value="{{ old('email') }}" />
        </div>

        <div class="input-group">
            <label class="label" for="password">Password</label>
            <input required placeholder="Enter your password" name="password" id="password" type="password" />
        </div>

        <div class="forgot-password">
            <a href="{{ route('password.request') }}">Forgot password?</a>
        </div>

        <button class="submit" type="submit">Sign In</button>

        <div class="signup-link">
            Don't have an account? <a href="{{ route('register') }}">Sign up</a>
        </div>
    </form>
@endsection
