<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Tawseel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .dashboard-container {
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .sidebar {
            background-color: #343a40;
            min-height: 100vh;
            padding: 20px;
            color: white;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, .8);
            padding: 10px 15px;
            margin: 5px 0;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, .1);
            color: white;
        }

        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, .1);
            color: white;
        }

        .main-content {
            padding: 30px;
        }

        .welcome-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
        }

        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
        }

        .user-info {
            padding: 15px;
            background: rgba(255, 255, 255, .1);
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
    @yield('styles')
</head>

<body>
    <div class="dashboard-container">
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-3 col-lg-2 sidebar">
                    <h3 class="mb-4">Tawseel</h3>
                    <div class="user-info">
                        <h6>Welcome,</h6>
                        <p class="mb-0">{{ Auth::user()->name }}</p>
                    </div>
                    <nav class="nav flex-column">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                        <a class="nav-link {{ request()->routeIs('dashboard.profile') ? 'active' : '' }}"
                            href="{{ route('dashboard.profile') }}">
                            <i class="fas fa-user"></i> Profile
                        </a>
                        <a class="nav-link {{ request()->routeIs('dashboard.orders') ? 'active' : '' }}"
                            href="{{ route('dashboard.orders') }}">
                            <i class="fas fa-shopping-cart"></i> Orders
                        </a>
                        <a class="nav-link {{ request()->routeIs('dashboard.settings') ? 'active' : '' }}"
                            href="{{ route('dashboard.settings') }}">
                            <i class="fas fa-cog"></i> Settings
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                            @csrf
                            <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </nav>
                </div>

                <!-- Main Content -->
                <div class="col-md-9 col-lg-10 main-content">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ session('warning') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            {{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>
