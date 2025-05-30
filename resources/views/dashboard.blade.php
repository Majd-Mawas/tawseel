@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    <div class="welcome-card mb-4">
        <h2>Welcome to Your Dashboard</h2>
        <p class="text-muted">Here's an overview of your account</p>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="stats-card">
                <h5>Profile Status</h5>
                <p class="mb-0">Email: {{ Auth::user()->email }}</p>
                <p class="mb-0">Phone: {{ Auth::user()->phone }}</p>
                <p class="mb-0">Gender: {{ ucfirst(Auth::user()->gender) }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <h5>Address</h5>
                <p class="mb-0">{{ Auth::user()->address }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stats-card">
                <h5>Account Status</h5>
                <p class="mb-0">Member since: {{ Auth::user()->created_at->format('M d, Y') }}</p>
                <p class="mb-0">Email verified: {{ Auth::user()->email_verified_at ? 'Yes' : 'No' }}</p>
            </div>
        </div>
    </div>
@endsection
