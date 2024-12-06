@extends('layouts.app')
@section('title', 'Profile Manager')    
@section('content')
<div class="container mt-4">
    <h2>Detail Invoice</h2>

    <table class="table">
        <tr>
            <th>ID:</th>
            <td>{{ $purchases->id }}</td>
        </tr>
        <tr>
            <th>Invoice ID:</th>
            <td style="text-transform:uppercase;">{{ $purchases->invoice_id }}</td>
        </tr>
        <tr>
            <th>Service Name:</th>
            <td>{{ $purchases->service_name }}</td>
        </tr>
        <tr>
            <th>Customer Name:</th>
            <td>{{ $purchases->buyer->name }}</td>
        </tr>
        <tr>
            <th>Total Price:</th>
            <td>Rp {{ number_format($purchases->total_price, 2) }}</td>
        </tr>
        <th>Discount Code:</th>
            <td>
                @if($purchases->discount_code)
                    {{ $discount }} ({{ $discountamount }})
                @else
                    <em>No discount applied</em>
                @endif
            </td>
        <tr>
            <th>Status:</th>
            <td>{{ ucfirst($purchases->status) }}</td>
        </tr>
        <tr>
            <th>Address:</th>
            <td>{{ $purchases->address }}</td>
        </tr>
        <tr>
            <th>Phone:</th>
            <td>{{ $purchases->phone }}</td>
        </tr>
        <tr>
            <th>Note:</th>
            <td>{{ $purchases->note }}</td>
        </tr>
        <tr>
            <th>Proof:</th>
            <td>
                @if ($purchases->proof)
                    <img src="{{ asset('storage/' . $purchases->proof) }}" alt="Proof" style="max-width: 200px;">
                @else
                    <em>No proof uploaded</em>
                @endif
            </td>
        </tr>
    </table>

    <form action="{{ route('admin.purchases.updateStatus', $purchases->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="status" class="form-label">Change Status:</label>
            <select name="status" id="status" class="form-select" required>
                <option value="Finished" {{ $purchases->status == 'Finished' ? 'selected' : '' }}>Finished</option>
                <option value="Paid" {{ $purchases->status == 'Paid' ? 'selected' : '' }}>Paid</option>
                <option value="Waiting Payment" {{ $purchases->status == 'waiting payment' ? 'selected' : '' }}>Waiting Payment</option>
                <option value="Rejected" {{ $purchases->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Status</button>
    </form>

    <a href="{{ route('admin.purchases.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
@endsection
