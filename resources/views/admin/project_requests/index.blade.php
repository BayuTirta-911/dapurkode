@extends('layouts.app')

@section('title', 'Manage Project Requests')

@section('content')
<div class="container mt-5">
    <h1 class="text-primary mb-4">Project Requests</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Installer</th>
                <th>Service</th>
                <th>Reason</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $request)
                <tr>
                    <td>{{ $request->id }}</td>
                    <td>{{ $request->installer->name }}</td>
                    <td>{{ $request->invoice->service_name }}</td>
                    <td>{{ $request->reason ?: 'No reason provided' }}</td>
                    <td>
                        <!-- Form untuk approve -->
                        <form action="{{ route('admin.project_requests.approve', $request->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Are you sure to approve this request?');">Approve</button>
                        </form>

                        <!-- Button untuk reject -->
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $request->id }}">Reject</button>

                        <!-- Modal untuk reject -->
                        <div class="modal fade" id="rejectModal-{{ $request->id }}" tabindex="-1" aria-labelledby="rejectModalLabel-{{ $request->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('admin.project_requests.reject', $request->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="rejectModalLabel-{{ $request->id }}">Reject Request</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="rejection-reason-{{ $request->id }}" class="form-label">Reason for Rejection</label>
                                                <textarea name="rejection_reason" id="rejection-reason-{{ $request->id }}" class="form-control" rows="3" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-danger">Reject</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- End Modal -->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
