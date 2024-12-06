@extends('layouts.app') <!-- Menggunakan layout utama -->

@section('title', 'Add Service')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Add New Service</h4>
            <!-- Jika ada pesan sukses -->
            

            <!-- Form untuk menambah service -->
            <form action="{{ route('vendor.services.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Input untuk Nama Service -->
                <div class="mb-3">
                    <label for="name" class="form-label">Service Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <!-- Input untuk Deskripsi -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                </div>

                <!-- Input untuk Price 1 -->
                <div class="mb-3">
                    <label for="price_1" class="form-label">Price </label>
                    <input type="number" name="price_1" id="price_1" class="form-control" value="{{ old('price_1') }}" required>
                </div>

                <!-- Input untuk Price 2 (Optional) -->
                <!-- <div class="mb-3">
                    <label for="price_2" class="form-label">Price 2 (Optional)</label>
                    <input type="number" name="price_2" id="price_2" class="form-control" value="{{ old('price_2') }}">
                </div> -->

                <!-- Input untuk Price 3 (Optional) -->
                <!-- <div class="mb-3">
                    <label for="price_3" class="form-label">Price 3 (Optional)</label>
                    <input type="number" name="price_3" id="price_3" class="form-control" value="{{ old('price_3') }}">
                </div> -->

                <!-- Input untuk Gambar -->
                <div class="mb-3">
                    <label for="image" class="form-label">Service Image</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn btn-primary">Save Service</button>
                <a href="{{ route('vendor.services.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
