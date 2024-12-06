@extends('layouts.app')

@section('title', 'Edit Fees')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Fees for {{ $service->name }}</h4>

            <!-- Form untuk mengubah fee -->
            <form action="{{ route('admin.services.update_fees', $service->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Input Installer Fee -->
                <div class="mb-3">
                    <label for="installer_fee" class="form-label">Installer Fee</label>
                    <input type="number" name="installer_fee" id="installer_fee" class="form-control" value="{{ old('installer_fee', $service->installer_fee) }}" step="0.01" min="0" required>
                </div>

                <!-- Input Affiliator Fee -->
                <div class="mb-3">
                    <label for="affiliator_fee" class="form-label">Affiliator Fee</label>
                    <input type="number" name="affiliator_fee" id="affiliator_fee" class="form-control" value="{{ old('affiliator_fee', $service->affiliator_fee) }}" step="0.01" min="0" required>
                </div>

                <!-- Input Other Fee -->
                <div class="mb-3">
                    <label for="other_fee" class="form-label">Other Fee</label>
                    <input type="number" name="other_fee" id="other_fee" class="form-control" value="{{ old('other_fee', $service->other_fee) }}" step="0.01" min="0" required>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
