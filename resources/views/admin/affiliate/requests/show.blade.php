@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3>Affiliate Request Details</h3>

    <table class="table">
        <tr>
            <th>User:</th>
            <td>{{ $request->user->name }}</td>
        </tr>
        <tr>
            <th>Description:</th>
            <td>{{ $request->self_description }}</td>
        </tr>
        <tr>
            <th>Marketing Plan:</th>
            <td>{{ $request->marketing_plan }}</td>
        </tr>
        <tr>
            <th>Status:</th>
            <td>{{ ucfirst($request->status) }}</td>
        </tr>
        <tr>
            <th>Admin Note:</th>
            <td>{{ $request->admin_note ?: '-' }}</td>
        </tr>
        <tr>
            <th>Affiliate Code:</th>
            <td>{{ $request->affiliate_code ?: '-' }}</td>
        </tr>
    </table>

    <form action="{{ route('admin.affiliate.requests.update', $request->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="Pending" {{ $request->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Accepted" {{ $request->status == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                <option value="Rejected" {{ $request->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="admin_note" class="form-label">Admin Note</label>
            <textarea class="form-control" id="admin_note" name="admin_note" rows="4">{{ $request->admin_note }}</textarea>
        </div>
        <div class="mb-3">
            <label for="affiliate_code" class="form-label">Affiliate Code</label>
            <input type="text" class="form-control" id="affiliate_code" name="affiliate_code" value="{{ $request->affiliate_code }}">
        </div>
        <button type="submit" class="btn btn-primary">Update Request</button>
    </form>
</div>
@endsection
