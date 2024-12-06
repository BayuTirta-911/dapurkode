@extends('layouts.app')

@section('title', 'Affiliate Balance')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="text-primary text-center mb-4">Affiliate Balance</h1>
            <p class="text-center text-muted">Track your current balance and claimable rewards easily.</p>

            <!-- Current Balance Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold text-secondary">
                        <i class="bi bi-wallet2 me-2"></i>Current Balance
                    </h5>
                    <p class="fs-2 fw-semibold text-success">Rp {{ number_format($user->balance, 2) }}</p>
                </div>
            </div>

            <!-- Potential Reward Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title fw-bold text-secondary">
                        <i class="bi bi-cash-coin me-2"></i>Potential Reward
                    </h5>
                    <p class="fs-2 fw-semibold text-info">Rp {{ number_format($potentialReward, 2) }}</p>
                </div>
            </div>

            <!-- Update Balance Button -->
            <form action="{{ route('affiliate.balance.update') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">
                    <i class="bi bi-arrow-repeat me-2"></i>Update Balance
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
