@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container mt-5">
    <!-- Title Section -->
    <h1 class="text-primary text-center mb-4">My Profile</h1>

    

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <!-- Profile Image -->
                    <div class="mb-3">
                        @if (auth()->user()->profile_photo)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" class="rounded-circle img-fluid" alt="Profile Photo" style="width: 150px; height: auto;">
                        @else
                            <img src="{{ asset('assets/images/profile/user-3.jpg') }}" class="rounded-circle img-fluid" alt="Default Profile Photo" style="width: 150px; height: auto;">
                        @endif
                    </div>

                    <!-- Name and Status -->
                    <h4 class="card-title fw-semibold mb-2">{{ auth()->user()->name }}
                        @if (auth()->user()->status === 'verified')    
                            <iconify-icon icon="material-symbols:verified" style="color: #4caf50;"></iconify-icon>
                        @endif
                    </h4>

                    <!-- User Details -->
                    <p class="card-text text-muted fs-5">
                        <strong>Email:</strong> {{ auth()->user()->email }}<br>
                        <strong>Role:</strong> 
                        <span class="badge bg-info text-white">{{ ucfirst(auth()->user()->role) }}</span><br>
                        <strong>Joined:</strong> {{ auth()->user()->created_at->format('d M Y') }}
                    </p>

                    <!-- Edit Profile Button -->
                    <a href="{{ route('profile.edit') }}" class="btn btn-warning btn-lg">
                        <i class="bi bi-pencil-square me-2"></i>Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
