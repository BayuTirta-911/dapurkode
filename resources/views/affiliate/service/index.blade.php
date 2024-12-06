@extends('layouts.app')

@section('title', 'Promote Services')

@section('content')
<div class="container mt-5">
    <h1 class="text-primary mb-4 text-center">Services You Can Promote</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @foreach ($services as $service)
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
        @endforeach
    </div>
</div>
@endsection
