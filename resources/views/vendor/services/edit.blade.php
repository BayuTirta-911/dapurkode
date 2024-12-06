@extends('layouts.app') <!-- Menggunakan layout utama -->

@section('title', 'Edit Service')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Edit Service</h4>

            

            <!-- Menampilkan form untuk mengedit service -->
            <form action="{{ route('vendor.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT') <!-- Menandakan bahwa ini adalah update -->

                <!-- Input untuk Nama Service -->
                <div class="mb-3">
                    <label for="name" class="form-label">Service Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $service->name) }}" required>
                </div>

                <!-- Input untuk Deskripsi -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description', $service->description) }}</textarea>
                </div>

                <!-- Input untuk Price 1 -->
                <div class="mb-3">
                    <label for="price_1" class="form-label">Price 1</label>
                    <input type="number" name="price_1" id="price_1" class="form-control" value="{{ old('price_1', $service->price_1) }}" required>
                </div>

                <!-- Input untuk Price 2 (optional) -->
                <div class="mb-3">
                    <label for="price_2" class="form-label">Price 2 (Optional)</label>
                    <input type="number" name="price_2" id="price_2" class="form-control" value="{{ old('price_2', $service->price_2) }}">
                </div>

                <!-- Input untuk Price 3 (optional) -->
                <div class="mb-3">
                    <label for="price_3" class="form-label">Price 3 (Optional)</label>
                    <input type="number" name="price_3" id="price_3" class="form-control" value="{{ old('price_3', $service->price_3) }}">
                </div>

                <!-- Upload Image -->
                <div class="mb-3">
                    <label for="image" class="form-label">Service Image</label>
                    @if ($service->image)
                        <div class="mb-2">
                            <p>Current Image:</p>
                            <img src="{{ asset('storage/' . $service->image) }}" alt="Service Image" class="img-thumbnail" width="150">
                        </div>
                    @endif
                    <input type="file" name="image" id="image" class="form-control">
                </div>

                <!-- Tombol Aksi -->
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="{{ route('vendor.services.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
