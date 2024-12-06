@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ route('signup.post') }}">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="vendor">Vendor</option>
                <option value="installer">Installer</option>
                <option value="affiliator">Affiliator</option>
            </select>
        </div><br>
        <button type="submit" class="btn btn-primary">Sign Up</button>
    </form>
</div>
@endsection
