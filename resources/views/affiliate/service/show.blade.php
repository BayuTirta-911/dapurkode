@extends('layouts.app')

@section('title', 'Service Details')

@section('content')
<div class="container mt-5">
    <!-- Title -->
    <h1 class="text-primary text-center mb-4">{{ $service->name }}</h1>

    <!-- Service Details Section -->
    <div class="row">
        <!-- Service Content -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Gambar Service -->
                    <div class="mb-4">
                        @if ($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" class="img-fluid w-100 rounded" alt="{{ $service->name }}">
                        @else
                            <img src="https://via.placeholder.com/600x400" class="img-fluid w-100 rounded" alt="Default Service Image">
                        @endif
                    </div>

                    <!-- Service Description -->
                    <h4 class="card-title text-secondary mb-3">{{ $service->name }}</h4>
                    <p class="fs-5 text-muted">{{ $service->description }}</p>

                    <div class="mt-4">
                        <p><strong>Price:</strong> Rp {{ number_format($service->price_1, 2) }}</p>
                        <p><strong>Status:</strong> <span class="badge bg-success">Approved</span></p>
                    </div>

                    <!-- Affiliate Link Section -->
                    <div class="mt-5">
                        <h5 class="text-secondary">Affiliate Link</h5>
                        <p>Copy the link below to promote the service:</p>

                        <div class="input-group">
                            <input type="text" class="form-control" id="affiliate-link" value="{{ $affiliateLink }}" readonly>
                            <button class="btn btn-outline-primary" onclick="copyLink()">Copy</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar (Optional) -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">About the Service</h5>
                    <p class="fs-6 text-muted">Learn more about this service and how it can benefit your audience. Share it with your followers!</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyLink() {
        var copyText = document.getElementById("affiliate-link");
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand("copy");
        alert("Affiliate link copied: " + copyText.value);
    }
</script>

@endsection
