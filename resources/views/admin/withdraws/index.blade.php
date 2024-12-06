@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-primary mb-4">Manage Withdraw Requests</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $request)
                    <tr>
                        <td>{{ $request->id }}</td>
                        <td>{{ $request->user->name }}</td>
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
                            @if ($request->status === 'Pending')
                                <!-- Approve Form -->
                                <form action="{{ route('admin.withdraws.approve', $request->id) }}" method="POST" enctype="multipart/form-data" class="d-inline-block">
                                    @csrf
                                    <label for="proof-{{ $request->id }}" class="form-label mb-0">Upload Proof:</label>
                                    <input type="file" name="proof" id="proof-{{ $request->id }}" class="form-control form-control-sm mb-2" required>
                                    <button type="submit" class="btn btn-success btn-sm w-100">
                                        <i class="bi bi-check-circle me-1"></i>Approve
                                    </button>
                                </form>

                                <!-- Reject Form -->
                                <form action="{{ route('admin.withdraws.reject', $request->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    <textarea name="rejection_reason" class="form-control form-control-sm mb-2" placeholder="Reason for rejection" required></textarea>
                                    <button type="submit" class="btn btn-danger btn-sm w-100">
                                        <i class="bi bi-x-circle me-1"></i>Reject
                                    </button>
                                </form>
                            @else
                                <span>-</span>
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
