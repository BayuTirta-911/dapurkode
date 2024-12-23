@extends('layouts.visitor')

@section('title', 'Our Services')

@section('content')
<style>
    .card-img-top {
    height: 200px;
    object-fit: cover;
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
    }

    .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .card:hover {
        transform: scale(1.03);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

</style>
<div class="container py-5">
    <h2 class="text-center mb-4">Our Services</h2>

    <!-- Search Bar -->
    <form action="{{ route('visitor.services') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search for services..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <!-- Services Grid -->
    <div class="row">
        @foreach ($services as $service)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('storage/' . $service->image) }}" class="card-img-top" alt="{{ $service->name }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $service->name }}</h5>
                        <p class="card-text text-muted mb-3">{{ Str::limit($service->description, 60, '...') }}</p>
                        <p class="card-text text-muted mb-3">Rp {{ number_format($service->price_1+$service->installer_fee+$service->affiliator_fee+$service->other_fee, 2) }}</p>
                        <a href="#" class="btn btn-primary mt-auto">Learn More</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $services->withQueryString()->links() }}
    </div>
</div>
@endsection
