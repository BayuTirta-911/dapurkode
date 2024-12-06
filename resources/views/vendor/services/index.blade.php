@extends('layouts.app') <!-- Menggunakan layout utama -->

@section('title', 'My Services')

@section('content')
<div class="container-fluid">

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">My Services</h4>

            <!-- Tombol Tambah Service -->
            <div class="mb-3 text-end">
                <a href="{{ route('vendor.services.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Add New Service
                </a>
            </div>

            <!-- Menampilkan daftar service -->
            @if ($services->isEmpty())
                <div class="alert alert-info">
                    You have not added any services yet. Click "Add New Service" to get started.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Service Name</th>
                                <th>Description</th>
                                <th>group Service</th>
                                <th>Price 1</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $index => $service)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $service->name }}</td>
                                    <td>{{ Str::limit($service->description, 50, '...') }}</td>
                                    <td>{{ $service->group->name ?? 'No Group' }}</td>
                                    <td>Rp.{{ number_format($service->price_1, 2) }}</td>
                                    <td>
                                        @if ($service->status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif ($service->status === 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <!-- Edit Button -->
                                        <a href="{{ route('vendor.services.edit', $service->id) }}" class="btn btn-warning btn-sm">
                                            <i class="ti ti-edit"></i> Edit
                                        </a>
                                        <!-- Delete Button -->
                                        <form action="{{ route('vendor.services.destroy', $service->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this service?')">
                                                <i class="ti ti-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
