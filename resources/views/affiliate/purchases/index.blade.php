@extends('layouts.app')

@section('title', 'Affiliate Purchases')

@section('content')
<div class="container mt-5">
    <h1 class="text-primary">Affiliate Purchases</h1>
    <p>Below is a list of purchases made using your affiliate code.</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Buyer Name</th>
                <th>Service Name</th>
                <th>Total Price</th>
                <th>Purchase Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($purchases as $purchase)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $purchase->buyer->name ?? 'Unknown' }}</td>
                    <td>{{ $purchase->service_name }}</td>
                    <td>Rp {{ number_format($purchase->total_price, 2) }}</td>
                    <td>{{ $purchase->created_at->format('d M Y, H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No purchases found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
