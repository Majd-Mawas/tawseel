<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Tawseel</title>
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
    @if (request()->routeIs('password.reset') || request()->routeIs('password.request'))
        <link rel="stylesheet" href="{{ asset('css/auth/reset-password.css') }}">
    @endif
</head>

<body>
    @yield('content')
</body>

</html>
