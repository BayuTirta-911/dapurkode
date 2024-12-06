@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-5">
    <!-- Welcome Section -->
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="card-title text-primary fw-bold">Welcome, {{ auth()->user()->name }}!</h1>
                    <p class="card-text">
                        You are currently logged in as:
                        <span class="badge 
                            @if(auth()->user()->role === 'admin') bg-danger 
                            @elseif(auth()->user()->role === 'vendor') bg-success 
                            @elseif(auth()->user()->role === 'affiliator') bg-warning 
                            @elseif(auth()->user()->role === 'installer') bg-secondary 
                            @elseif(auth()->user()->role === 'user') bg-primary 
                            @endif">
                            {{ ucfirst(auth()->user()->role) }}
                        </span>
                        
                    </p>
                    <hr>
                    <p class="text-muted">Explore your dashboard to access various features and manage your account efficiently.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Features Section -->
    <div class="row mt-5">
        <!-- Example Feature 1 -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-person-circle display-3 text-primary"></i>
                    <h5 class="card-title mt-3">Profile</h5>
                    <p class="card-text text-muted">View and update your personal information.</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">Go to Profile</a>
                </div>
            </div>
        </div>

        <!-- Example Feature 2 -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-basket-fill display-3 text-success"></i>
                    <h5 class="card-title mt-3">My Purchases</h5>
                    <p class="card-text text-muted">Track your purchase history and invoices.</p>
                    <a href="{{ route('user.invoices.index') }}" class="btn btn-success btn-sm">View Purchases</a>
                </div>
            </div>
        </div>

        <!-- Example Feature 3 -->
        @if(auth()->user()->role === 'vendor')
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-layers-fill display-3 text-warning"></i>
                    <h5 class="card-title mt-3">Manage Services</h5>
                    <p class="card-text text-muted">Add, edit, and organize your services.</p>
                    <a href="{{ route('vendor.services.index') }}" class="btn btn-warning btn-sm">Manage Services</a>
                </div>
            </div>
        </div>
        @endif

        <!-- Example Feature for Admin -->
        @if(auth()->user()->role === 'admin')
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-gear-fill display-3 text-danger"></i>
                    <h5 class="card-title mt-3">Invoices Management</h5>
                    <p class="card-text text-muted">Oversee Purchase invoice and other stuff.</p>
                    <a href="{{ route('admin.purchases.index') }}" class="btn btn-danger btn-sm">Go to Invoices Management</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
