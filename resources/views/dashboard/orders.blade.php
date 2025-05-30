@extends('layouts.dashboard')

@section('title', 'Orders')

@section('content')
    <div class="welcome-card mb-4">
        <h2>My Orders</h2>
        <p class="text-muted">View and manage your orders</p>
    </div>

    <div class="stats-card">
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
            <h4>No Orders Yet</h4>
            <p class="text-muted">Your order history will appear here</p>
        </div>
    </div>
@endsection
