@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mt-5">
    <!-- Title Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary">Admin Dashboard</h1>
    </div>

    <!-- Statistics Section -->
    <div class="row g-4">
        <!-- Pending Services -->
        <div class="col-lg-4 col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center">
                    <i class="bi bi-clock-history display-3 text-warning"></i>
                    <h5 class="card-title mt-3 fw-semibold">Pending Services</h5>
                    <p class="fs-4 fw-bold text-secondary">{{ $pendingServicesCount }}</p>
                </div>
                <div class="card-footer bg-light text-center">
                    <a href="{{ route('admin.services.index') }}" class="text-decoration-none text-warning fw-bold">
                        View Details <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Paid Invoices -->
        <div class="col-lg-4 col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center">
                    <i class="bi bi-receipt-cutoff display-3 text-success"></i>
                    <h5 class="card-title mt-3 fw-semibold">Paid Invoices</h5>
                    <p class="fs-4 fw-bold text-secondary">{{ $paidInvoicesCount }}</p>
                </div>
                <div class="card-footer bg-light text-center">
                    <a href="{{ route('admin.purchases.index') }}" class="text-decoration-none text-success fw-bold">
                        View Details <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Pending Affiliate Requests -->
        <div class="col-lg-4 col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center">
                    <i class="bi bi-person-plus-fill display-3 text-primary"></i>
                    <h5 class="card-title mt-3 fw-semibold">Pending Affiliate Requests</h5>
                    <p class="fs-4 fw-bold text-secondary">{{ $pendingAffiliateRequestsCount }}</p>
                </div>
                <div class="card-footer bg-light text-center">
                    <a href="{{ route('admin.affiliate.requests.index') }}" class="text-decoration-none text-primary fw-bold">
                        View Details <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
