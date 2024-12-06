@extends('layouts.app')

@section('title', 'Vendor Balance')

@section('content')
<div class="container mt-5">
    <h1 class="text-primary">Vendor Balance</h1>
    <p>Your current balance and potential rewards are shown below:</p>


    <!-- Saldo Saat Ini -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Current Balance</h5>
            <p class="fs-3 text-success">Rp {{ number_format($user->balance, 2) }}</p>
        </div>
    </div>

    <!-- Reward Potensial -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Potential Reward</h5>
            <p class="fs-3 text-info">Rp {{ number_format($potentialReward, 2) }}</p>
        </div>
    </div>

    <!-- Tombol Update Saldo -->
    <form action="{{ route('vendor.balance.update') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary w-100">Update Balance</button>
    </form>
</div>
@endsection
