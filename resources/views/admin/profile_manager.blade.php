@extends('layouts.app') <!-- Menggunakan layout utama -->

@section('title', 'Profile Manager')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
        
            <h4 class="card-title">Profile Manager</h4>

            <!-- Search Bar -->
            <form action="{{ route('admin.profile_manager') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control" 
                        placeholder="Search by name or email..." 
                        value="{{ old('search', $search) }}" 
                    >
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>{{ ucfirst($user->status) }}</td>
                            <td>
                                @if ($user->role !== 'admin')
                                    <!-- Change Status Button -->
                                    <form action="{{ route('admin.change_status', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" class="form-control" style="width: 150px; display: inline-block;">
                                            <option value="normal" {{ $user->status == 'normal' ? 'selected' : '' }}>Normal</option>
                                            <option value="verified" {{ $user->status == 'verified' ? 'selected' : '' }}>Verified</option>
                                            <option value="banned" {{ $user->status == 'banned' ? 'selected' : '' }}>Banned</option>
                                        </select><br>
                                        <button type="submit" class="btn btn-primary btn-sm">Change Status</button>
                                    </form>
                                @endif
                                <!-- Delete Form -->
                                <form action="{{ route('admin.delete_profile', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No users found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
