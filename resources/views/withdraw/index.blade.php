@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-primary mb-4 text-center">Withdraw Balance</h1>

    <!-- Withdraw Form -->
    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <h5 class="card-title text-secondary mb-4">Request a Withdraw</h5>
            <form action="{{ route('withdraw.request') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="amount" class="form-label">Withdraw Amount</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter amount" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-arrow-right-circle me-1"></i> Submit Request
                </button>
            </form>
        </div>
    </div>

    <!-- Withdraw Requests Table -->
    <h2 class="text-secondary mb-4">Your Withdraw Requests</h2>
    <div class="table-responsive">
        <table class="table table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Requested at</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Proof</th>
                    <th>Rejection Reason</th> <!-- New Column for Rejection Reason -->
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $request)
                    <tr>
                        <td>{{ $request->created_at }}</td>
                        <td>Rp {{ number_format($request->amount, 2) }}</td>
                        <td>
                            @if ($request->status === 'Pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif ($request->status === 'Approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif ($request->status === 'Rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>
                            @if ($request->proof)
                                <a href="{{ asset('storage/' . $request->proof) }}" class="btn btn-outline-info btn-sm" target="_blank">
                                    <i class="bi bi-file-earmark-image"></i> View Proof
                                </a>
                            @else
                                <em class="text-muted">No proof available</em>
                            @endif
                        </td>
                        <td>
                            @if ($request->status === 'Rejected' && $request->rejection_reason)
                                <span class="text-danger">{{ $request->rejection_reason }}</span>
                            @else
                                <em>-</em>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-muted">No withdraw requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
