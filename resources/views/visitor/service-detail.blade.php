@extends('layouts.visitor')

@section('title',  $service->name)

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Service Image -->
        <div class="col-md-6">
            <img src="{{ asset('storage/' . $service->image) }}" class="img-fluid rounded" alt="{{ $service->name }}">
        </div>
        <!-- Service Details -->
        <div class="col-md-6">
            <h2>{{ $service->name }}</h2>
            <p class="text-muted">Created on {{ $service->created_at->format('d M, Y') }}</p>
            <hr>
            <h4 class="text-primary">Rp {{ number_format($service->price_1+$service->installer_fee+$service->affiliator_fee+$service->other_fee, 2) }}</h4>
            <p class="mt-4">{!! $service->description !!}</p>
            <hr>
            <a href="{{ route('invoice.show',$service->id) }}" class="btn btn-primary">Buy This Service</a>
            <a href="{{ route('visitor.services') }}" class="btn btn-secondary">Back to Services</a>
        </div>
    </div>

    <!-- Related Services -->
    <div class="mt-5">
        <h4>Related Services</h4>
        <div class="row">
            @forelse ($relatedServices as $related)
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="{{ asset('storage/' . $related->image) }}" class="card-img-top" alt="{{ $related->name }}">
                        <div class="card-body">
                            <h6 class="card-title">{{ $related->name }}</h6>
                            <p class="card-text text-muted mb-3">{{ Str::limit(strip_tags($related->description), 60, '...') }}</p>
                            <p class="text-muted">Rp {{ number_format($related->price_1+$related->installer_fee+$related->affiliator_fee+$related->other_fee, 2) }}</p>
                            <a href="{{ route('visitor.service-detail', $related->id) }}" class="btn btn-primary btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>No related services available.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
