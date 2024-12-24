@extends('layouts.visitor')

@section('title', 'Welcome to Our Website')

@section('content')
<style>
    .carousel-item img {
    border-radius: 10px;
    object-fit: cover;
    height: 500px;
    }
    .carousel-inner {
        padding: 15px;
        background:rgba(248, 249, 250, 0.61);
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .carousel-item .col-md-4 {
        text-align: left;
        color: #333; /* Warna teks */
        padding: 20px;
        border-radius: 8px;
        background-color:rgba(245, 245, 245, 0.63);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border: none;
    transition: transform 0.3s, box-shadow 0.3s;
}

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }
    .card-img-top {
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
    }

</style>
<div class="container mt-5">

    <!-- Highlighted Services Carousel -->
    <div id="highlightCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($highlightedServices as $key => $service)
                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                    <div class="row">
                        <div class="col-md-8">
                            <img src="{{ asset('storage/' . $service->image) }}" class="d-block w-100" alt="{{ $service->name }}">
                        </div>
                        <div class="col-md-4 d-flex flex-column justify-content-center">
                            <h3>{{ $service->name }}</h3>
                            <p>{{ Str::limit($service->description, 150) }}</p>
                            <p class="text-muted">Price: Rp {{ number_format($service->price_1+$service->installer_fee+$service->affiliator_fee+$service->other_fee, 2) }}</p>
                            <a href="{{ route('visitor.service-detail', $service->id) }}" class="btn btn-info">Learn More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#highlightCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#highlightCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Latest Approved Services</h2>
            <div class="row">
                @foreach ($approvedServices as $service)
                    <div class="col-md-3">
                        <div class="card">
                            <img src="{{ asset('storage/' . $service->image) }}" class="card-img-top" alt="{{ $service->name }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $service->name }}</h5>
                                <p class="card-text text-muted">Rp {{ number_format($service->price_1+$service->installer_fee+$service->affiliator_fee+$service->other_fee, 2) }}</p>
                                <a href="{{ route('visitor.service-detail', $service->id) }}" class="btn btn-primary btn-sm">Learn More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('visitor.services') }}" class="btn btn-secondary">See More</a>
            </div>
        </div>
    </section>

</div>

@endsection
