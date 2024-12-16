@extends('layouts.app')

@section('title', 'Promote Services')

@section('content')
<div class="container mt-5">
    <h1 class="text-primary mb-4 text-center">Services You Can Promote</h1>

    
    <!-- Search Bar -->
    <form action="{{ route('affiliate.services.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input 
                type="text" 
                name="search" 
                class="form-control" 
                placeholder="Search services by name..." 
                value="{{ old('search', $search) }}" 
            >
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <!-- List of Services -->
    <div class="row">
        @forelse ($services as $service)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <img src="{{ asset('storage/' . $service->image) }}" class="card-img-top" alt="Service Image">
                    <div class="card-body">
                        <h5 class="card-title">{{ $service->name }}</h5>
                        <p class="card-text">{{ Str::limit($service->description, 100) }}</p>
                        <p class="text-muted">Price: Rp {{ number_format($service->price_1, 2) }}</p>
                        <a href="{{ route('affiliate.service.show', $service->id) }}" class="btn btn-info w-100">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted">No services found.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $services->links() }}
    </div>
</div>
@endsection
