@extends('layouts.app')

@section('title', 'Change Service Status')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Change Service Status</h4>

            <!-- Informasi Lengkap tentang Service -->
            <div class="mb-3">
                <label class="form-label">Service Name</label>
                <input type="text" class="form-control" value="{{ $service->name }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Vendor</label>
                <input type="text" class="form-control" value="{{ $service->user->name }} ({{ $service->user->email }})" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" rows="4" readonly>{{ $service->description }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">Price 1</label>
                    <input type="text" class="form-control" value="Rp.{{ number_format($service->price_1, 2) }}" readonly>
                </div>
                <!-- <div class="col-md-4">
                    <label class="form-label">Price 2 (Optional)</label>
                    <input type="text" class="form-control" value="{{ $service->price_2 ? 'Rp.' . number_format($service->price_2, 2) : 'N/A' }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Price 3 (Optional)</label>
                    <input type="text" class="form-control" value="{{ $service->price_3 ? 'Rp.' . number_format($service->price_3, 2) : 'N/A' }}" readonly>
                </div> -->
            </div>

            <div class="mb-3">
                <label class="form-label">Current Status</label>
                <input type="text" class="form-control" value="{{ ucfirst($service->status) }}" readonly>
            </div>

            @if ($service->image)
                <div class="mb-3">
                    <label class="form-label">Service Image</label>
                    <div>
                        <img src="{{ asset('storage/' . $service->image) }}" alt="Service Image" class="img-thumbnail" width="200">
                    </div>
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label">Admin Note</label>
                <textarea class="form-control" rows="4" readonly>{{ $service->admin_note ?? 'No notes added by admin yet.' }}</textarea>
            </div>

            <!-- Form untuk Mengubah Status -->
            <form action="{{ route('admin.services.update', $service->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="status" class="form-label">Change Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="pending" {{ $service->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $service->status === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $service->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="admin_note" class="form-label">Admin Note (Optional)</label>
                    <textarea name="admin_note" id="admin_note" class="form-control" rows="4">{{ $service->admin_note }}</textarea>
                </div>

                <!-- Tombol Aksi -->
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
