@extends('layouts.app')

@section('content')
<style>
    .card {
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card-header {
    border-radius: 10px 10px 0 0;
}

.card-body {
    padding: 20px;
}

.text-success {
    font-size: 1.25rem;
    font-weight: bold;
}

.lead {
    font-size: 1.2rem;
    font-weight: 600;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

</style>
<div class="container mt-5">

    <div class="card shadow-sm">
        <div class="card-body">
            <!-- Title -->
            <h5 class="card-title text-center mb-4">Invoice Payment</h5>

            <!-- Service Name and Total Price Section -->
            <div class="row mb-4">
                <div class="col-12 col-md-6">
                    <h6>Service Name</h6>
                    <p class="lead">{{ $purchase->invoice_id }} - {{ $purchase->service_name }}</p>
                </div>
                <div class="col-12 col-md-6">
                    <h6>Total Price</h6>
                    <p class="lead text-success">Rp {{ number_format($purchase->total_price, 2) }}</p>
                </div>
            </div>
            @if ($purchase->og_disc > 0.0) <!-- Kondisi benar -->
                <div class="row mb-4">
                    <div class="col-12 col-md-6">
                        <h6>Applied Discount Code</h6>
                        <p class="lead">{{ $purchase->discount_code }}</p>
                    </div>

                    @if ($purchase->og_disc >= 100.0) <!-- Cek jika diskon 100% atau lebih -->
                        <div class="col-12 col-md-6">
                            <h6>You Saved</h6>
                            <p class="lead text-success">
                                Rp {{ number_format($purchase->og_disc, 2) }}
                            </p>
                        </div>
                    @else <!-- Diskon dalam persentase -->
                        @php
                            // Hitung nilai diskon
                            $discountAmount = ($purchase->og_disc / 100) * $purchase->og_price;
                        @endphp
                        <div class="col-12 col-md-6">
                            <h6>You Saved {{ number_format($purchase->og_disc) }}%</h6>
                            <p class="lead text-success">
                                Rp {{ number_format($discountAmount, 2) }}
                            </p>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Bank Information Section -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Bank Information</h5>
                </div>
                <div class="card-body text-center">
                    @foreach($banks as $bank)
                        @if ($bank->id == $purchase->bank_id)
                            <h4 class="text-uppercase">{{ $bank->bank_name }}</h4>
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $bank->image) }}" alt="{{ $bank->bank_name }} Logo" style="max-width: 150px; height: auto;">
                            </div>
                            <p class="lead">Account Number: <strong>{{ $bank->account_number }}</strong></p>
                            <small class="text-muted">Please transfer the payment to the above account number.</small>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Upload Proof of Transfer Section -->
            <div class="mb-4">
                <h5>Upload Proof of Transfer</h5>
                <form action="{{ route('invoice.uploadProof', $purchase->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="proof" class="form-label">Choose File (Image)</label>
                        <input type="file" class="form-control" id="proof" name="proof" required>
                        @error('proof')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Upload Proof</button>
                </form>
            </div>

            <!-- Back to Dashboard Button -->
            <a href="{{ route('user.dashboard') }}" class="btn btn-secondary mt-3">Back to Dashboard</a>
        </div>
    </div>
</div>
@endsection
