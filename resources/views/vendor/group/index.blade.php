@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <!-- Title and Create Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Your Service Groups</h3>
        <a href="{{ route('vendor.groups.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Create Group
        </a>
    </div>

    <!-- Group Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Group Name</th>
                            <th>Description</th>
                            <th>Services</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($groups as $group)
                            <tr>
                                <td>{{ $group->id }}</td>
                                <td class="fw-bold">{{ $group->name }}</td>
                                <td>{{ $group->description ?: '-' }}</td>
                                <td>
                                    @if ($group->services->isEmpty())
                                        <span class="text-muted">No services</span>
                                    @else
                                        <ul class="list-unstyled mb-0">
                                            @foreach ($group->services as $service)
                                                <li><i class="bi bi-check-circle text-success"></i> {{ $service->name }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('vendor.groups.edit', $group->id) }}" class="btn btn-warning btn-sm me-1">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('vendor.groups.destroy', $group->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this group?')">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No groups available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
