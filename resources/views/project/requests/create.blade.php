@extends('layouts.app')

@section('title', 'Project Request')

@section('content')
<div class="container mt-5">
    <h1 class="text-primary text-center mb-4">Submit Project Request</h1>

    

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('project.requests.store') }}" method="POST">
        @csrf

        <!-- Dropdown untuk memilih service -->
        <div class="mb-3">
            <label for="invoice_id" class="form-label">Select Service</label>
            <select name="invoice_id" id="invoice_id" class="form-select" required>
                <option value="" disabled selected>-- Choose a Service --</option>
                @foreach ($invoices as $invoice)
                    <option value="{{ $invoice->id }}">
                    {{ $invoice->invoice_id }}-{{ $invoice->service_name }} (Total: Rp {{ number_format($invoice->total_price, 2) }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Alasan pengajuan -->
        <div class="mb-3">
            <label for="reason" class="form-label">Reason for Request</label>
            <textarea name="reason" id="reason" class="form-control" rows="4" placeholder="Explain why you're requesting this project (optional)"></textarea>
        </div>

        <!-- Tombol Kirim -->
        <button type="submit" class="btn btn-primary w-100">Submit Request</button>
    </form>
</div>
@endsection
