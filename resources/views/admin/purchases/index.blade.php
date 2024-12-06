@extends('layouts.app')
@section('title', 'Profile Manager')
@section('content')
<style>
    .badge.bg-success {
    background-color: #28a745;
    color: white;
}

.badge.bg-warning {
    background-color: #ffc107;
    color: black;
}

.badge.bg-danger {
    background-color: #dc3545;
    color: white;
}

.badge.bg-primary {
    background-color: #007bff;
    color: white;
}

</style>
<div class="container mt-4">
    <h2>Manage Purchases</h2>

   
    

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Invoice ID</th>
                <th>Service</th>
                <th>Total Price</th>
                <th>Referred by:</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchases as $purchase)
                <tr>
                    <td>{{ $purchase->id }}</td>
                    <td style="text-transform:uppercase;">{{ $purchase->invoice_id }}</td>
                    <td>{{ $purchase->service_name }}</td>
                    <td>Rp {{ number_format($purchase->total_price, 2) }}</td>
                    <td>{{ $purchase->affiliate_code }}</td>
                    <td>
                        <span class="badge 
                            @if ($purchase->status == 'paid') bg-success 
                            @elseif ($purchase->status == 'waiting payment') bg-warning 
                            @elseif ($purchase->status == 'rejected') bg-danger 
                            @elseif ($purchase->status == 'finished') bg-primary 
                            @endif">
                            {{ ucfirst($purchase->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.purchases.show', $purchase->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <form action="{{ route('admin.purchases.destroy', $purchase->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus invoice ini?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
