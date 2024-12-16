@extends('layouts.app')

@section('title', 'Manage Services')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Manage Vendor Services</h4>

            <!-- Search Bar -->
            <form action="{{ route('admin.services.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control" 
                        placeholder="Search by service name, vendor name, or email..." 
                        value="{{ old('search', $search) }}" 
                    >
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>

            <!-- Table for Service List -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Service Name</th>
                            <th>Vendor</th>
                            <th>Additional Fees</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($services as $index => $service)
                            <tr>
                                <td>{{ $loop->iteration + ($services->currentPage() - 1) * $services->perPage() }}</td>
                                <td>{{ $service->name }}</td>
                                <td>{{ $service->user->name }} ({{ $service->user->email }})</td>
                                <td>
                                    Installer fee: Rp {{ number_format($service->installer_fee, 2) }} <br>
                                    Affiliator fee: Rp {{ number_format($service->affiliator_fee, 2) }} <br>
                                    Other fee: Rp {{ number_format($service->other_fee, 2) }}
                                </td>
                                <td>
                                    @if ($service->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif ($service->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.services.edit_fees', $service->id) }}" class="btn btn-primary btn-sm">
                                        <i class="ti ti-edit"></i> Change Additional Fees
                                    </a><br><br>
                                    <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-primary btn-sm">
                                        <i class="ti ti-edit"></i> Details, and change Status
                                    </a><br><br>
                                    <button class="btn btn-info btn-sm" onclick="copyInvoiceLink({{ $service->id }})">
                                        <i class="ti ti-link"></i> Copy Invoice Link
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No services found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $services->links() }}
            </div>
        </div>
    </div>
</div>
<script>
    function copyInvoiceLink(id) {
        // Buat URL dengan ID yang sesuai
        const invoiceLink = `${window.location.origin}/invoice/${id}`;

        // Copy ke clipboard
        navigator.clipboard.writeText(invoiceLink)
            .then(() => {
                alert('Invoice link copied to clipboard!');
            })
            .catch(err => {
                console.error('Failed to copy: ', err);
                alert('Failed to copy the link.');
            });
    }
</script>

@endsection
