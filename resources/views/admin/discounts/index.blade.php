@extends('layouts.app')

@section('title', 'Manage Discounts')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Manage Discounts</h4>

            <!-- Tombol Tambah Diskon -->
            <a href="{{ route('admin.discounts.create') }}" class="btn btn-primary mb-3">
                <i class="ti ti-plus"></i> Create Discount
            </a>

            <!-- Search Bar -->
            <form action="{{ route('admin.discounts.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control" 
                        placeholder="Search by discount code or amount..." 
                        value="{{ old('search', $search) }}"
                    >
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>

            <!-- Tabel Diskon -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Amount</th>
                            <th>Services</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($discounts as $index => $discount)
                            <tr>
                                <td>{{ $loop->iteration + ($discounts->currentPage() - 1) * $discounts->perPage() }}</td>
                                <td>{{ $discount->code }}</td>
                                <td>Rp {{ number_format($discount->amount, 2) }}</td>
                                <td>
                                    @php
                                        $serviceIds = json_decode($discount->service_ids); // Decode string JSON menjadi array
                                    @endphp
                                    @foreach ($serviceIds as $service_id)
                                        @php
                                            $service = \App\Models\Service::find($service_id);
                                        @endphp
                                        @if ($service)
                                            <span class="badge bg-info">{{ $service->name }}</span>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <form action="{{ route('admin.discounts.destroy', $discount->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this discount?')">
                                            <i class="ti ti-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No discounts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $discounts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
