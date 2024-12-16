@extends('layouts.app')

@section('title', 'Project Requests')

@section('content')
<div class="container mt-5">
    <h1 class="text-primary mb-4">Your Project Requests</h1>

    

    <!-- Tombol untuk Membuat Request -->
    <div class="mb-4">
        <a href="{{ route('project.requests.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Request New Project
        </a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Service</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $request)
                <tr>
                    <td>{{ $request->id }}</td>
                    <td>{{ $request->invoice->service_name }}</td>
                    <td>
                        <span class="badge {{ $request->status === 'approved' ? 'bg-success' : ($request->status === 'rejected' ? 'bg-danger' : 'bg-warning') }}">
                            {{ ucfirst($request->status) }}
                        </span>
                    </td>
                    <td>
                        @if ($request->status === 'rejected')
                            <em>Reason: {{ $request->rejection_reason }}</em>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
