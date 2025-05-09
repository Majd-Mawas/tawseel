<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - Tawseel</title>
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
</head>

<body>
    <div class="signin-form">
        <div class="form-heading">Verify Your Email</div>

        <div class="alert alert-info"
            style="background-color: rgba(13, 110, 253, 0.1); border-color: rgba(13, 110, 253, 0.2); color: #0d6efd;">
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link
            we just emailed to you? If you didn't receive the email, we will gladly send you another.
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success"
                style="background-color: rgba(25, 135, 84, 0.1); border-color: rgba(25, 135, 84, 0.2); color: #198754;">
                A new verification link has been sent to the email address you provided during registration.
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}" style="margin-top: 20px;">
            @csrf
            <button type="submit" class="submit">Resend Verification Email</button>
        </form>

        <form method="POST" action="{{ route('logout') }}" style="margin-top: 20px;">
            @csrf
            <button type="submit" class="submit" style="background-color: #dc3545;">Log Out</button>
        </form>
    </div>
</body>

</html>
