@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container mt-4">
    <h1>Edit Profile</h1>

    
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">New Password (Optional, Keep it blank if you don't want to replace)</label>
            <input type="password" name="password" class="form-control" autocomplete="new-password">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="mb-3">
            <label for="profile_photo" class="form-label">Profile Photo</label>
            @if ($user->profile_photo)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" width="100" class="rounded-circle">
                </div>
            @endif
            <input type="file" name="profile_photo" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
