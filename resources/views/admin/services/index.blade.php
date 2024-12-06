@extends('layouts.app')

@section('title', 'Manage Services')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Manage Vendor Services</h4>

            

            <!-- Tabel untuk daftar service -->
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
                        @foreach ($services as $index => $service)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $service->name }}</td>
                                <td>{{ $service->user->name }} ({{ $service->user->email }})</td>
                                <td>Installer fee : Rp.{{ $service->installer_fee }} <br>
                                    Affiliator fee : Rp.{{ $service->affiliator_fee }} <br>
                                    Other fee : Rp.{{ $service->other_fee }}
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
                                        <i class="ti ti-edit"></i> Change Status
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
