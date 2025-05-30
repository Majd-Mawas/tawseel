<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Tawseel</title>
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
</head>

<body>
    <form class="signup-form" method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-heading">SIGN UP</div>

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
            <label class="label" for="name">USER NAME</label>
            <input required placeholder="Set your name" name="name" id="name" type="text"
                value="{{ old('name') }}" />
        </div>

        <div class="input-group">
            <label class="label" for="gender">GENDER</label>
            <select id="gender" name="gender">
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <div class="input-group">
            <label class="label" for="phone">PHONE NUMBER</label>
            <input required placeholder="Your mobile phone" name="phone" id="phone" type="text"
                value="{{ old('phone') }}" />
        </div>

        <div class="input-group">
            <label class="label" for="email">Email</label>
            <input required placeholder="Enter your email" name="email" id="email" type="email"
                value="{{ old('email') }}" />
        </div>

        <div class="input-group">
            <label class="label" for="password">Password</label>
            <input required placeholder="Enter your password" name="password" id="password" type="password" />
        </div>

        <div class="input-group">
            <label class="label" for="password_confirmation">Confirm Password</label>
            <input required placeholder="Confirm your password" name="password_confirmation" id="password_confirmation"
                type="password" />
        </div>

        <div class="input-group">
            <label class="label" for="address">ADDRESS</label>
            <textarea name="address" id="address" placeholder="Enter your address">{{ old('address') }}</textarea>
        </div>

        <button class="submit" type="submit">Sign Up</button>

        <div class="signin-link">
            Already have an account? <a href="{{ route('login') }}">Sign in</a>
        </div>
    </form>
</body>

</html>
