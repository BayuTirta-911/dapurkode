@extends('layouts.app')

@section('title', 'My Invoices')

@section('content')
<div class="container mt-5">

    <h3>My Invoices</h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Invoice ID</th>
                <th>Service Name</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->id }}</td>
                    <td style="text-transform:uppercase;">{{ $invoice->invoice_id }}</td>
                    <td>{{ $invoice->service_name }}</td>
                    <td>Rp {{ number_format($invoice->total_price, 2) }}</td>
                    <td>
                        <span class="badge 
                            @if ($invoice->status == 'paid') bg-success 
                            @elseif ($invoice->status == 'waiting payment') bg-warning 
                            @elseif ($invoice->status == 'rejected') bg-danger 
                            @elseif ($invoice->status == 'finished') bg-primary 
                            @endif">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('invoice.report', $invoice->id) }}" class="btn btn-info btn-sm">Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No invoices found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
