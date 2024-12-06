@extends('layouts.app')

@section('title', 'Project Details')

@section('content')
<div class="container mt-5">
    <h1 class="text-primary mb-4">Project Details</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Tabel Detail Proyek -->
    <table class="table table-bordered">
        <tr>
            <th>Service Name:</th>
            <td>{{ $invoice->service_name }}</td>
        </tr>
        <tr>
            <th>Status:</th>
            <td>
                <span class="badge 
                    {{ $invoice->project_status === 'finished' ? 'bg-success' : 
                       ($invoice->project_status === 'reviewing' ? 'bg-warning' : 'bg-info') }}">
                    {{ ucfirst($invoice->project_status) }}
                </span>
            </td>
        </tr>
        <tr>
            <th>Progress:</th>
            <td>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar 
                        {{ $invoice->progress_percentage == 100 ? 'bg-success' : 'bg-info' }}" 
                        role="progressbar" 
                        style="width: {{ $invoice->progress_percentage }}%;" 
                        aria-valuenow="{{ $invoice->progress_percentage }}" 
                        aria-valuemin="0" 
                        aria-valuemax="100">
                        {{ $invoice->progress_percentage }}%
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <th>Log:</th>
            <td>{{ $invoice->log ?? 'No log available' }}</td>
        </tr>
        <tr>
            <th>Last Updated:</th>
            <td>{{ $invoice->updated_at->format('d M Y H:i') }}</td>
        </tr>
    </table>

    <!-- Jika proyek berstatus wip, tampilkan opsi pengeditan -->
    @if($invoice->project_status === 'wip')
        <form action="{{ route('project.progress.update', $invoice->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="progress_percentage" class="form-label">Update Progress</label>
                <input type="number" name="progress_percentage" id="progress_percentage" 
                       class="form-control" value="{{ $invoice->progress_percentage }}" 
                       min="0" max="100" required>
            </div>

            <div class="mb-3">
                <label for="log" class="form-label">Update Log</label>
                <textarea name="log" id="log" class="form-control" rows="4">{{ $invoice->log }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save Progress</button>
        </form>

        <hr>

        <form action="{{ route('project.progress.complete', $invoice->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success mt-3" onclick="return confirm('Are you sure this project is complete?')">
                Complete Project
            </button>
        </form>
    @else
        <!-- Pesan jika proyek tidak bisa diubah -->
        <div class="alert alert-warning mt-3">
            This project is in <strong>{{ ucfirst($invoice->project_status) }}</strong> status and cannot be modified.
        </div>
    @endif

    <a href="{{ route('project.progress.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
@endsection
