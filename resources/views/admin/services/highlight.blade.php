@extends('layouts.app')

@section('title', 'Manage Highlighted Services')

@section('content')
<div class="container mt-5">
    <h1 class="text-primary">Manage Highlighted Services</h1>
    <p>Select up to 5 approved services to be highlighted.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Form Pencarian -->
    <form action="{{ route('admin.services.highlight') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input 
                type="text" 
                name="search" 
                class="form-control" 
                placeholder="Search for services..." 
                value="{{ $query ?? '' }}">
            <button type="submit" class="btn btn-outline-primary">Search</button>
        </div>
    </form>

    <form action="{{ route('admin.services.update_highlight') }}" method="POST">
        @csrf

        <div class="row">
            @foreach ($approvedServices as $service)
                <div class="col-md-4">
                    <div class="card mb-3 {{ $service->highlight ? 'border-success' : '' }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $service->name }}</h5>
                            <p class="card-text">{{ Str::limit($service->description, 100) }}</p>
                            <div class="form-check">
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    name="service_ids[]" 
                                    value="{{ $service->id }}" 
                                    id="service-{{ $service->id }}" 
                                    {{ $service->highlight ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="service-{{ $service->id }}">
                                    Highlight this service
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update Highlighted Services</button>
    </form>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $approvedServices->links() }}
    </div>

    <h3 class="mt-5">Currently Highlighted Services</h3>
    <ul>
        @foreach ($highlightedServices as $highlightedService)
            <li>{{ $highlightedService->name }}</li>
        @endforeach
    </ul>
</div>
@endsection
