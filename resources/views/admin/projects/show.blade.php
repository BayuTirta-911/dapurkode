@extends('layouts.app')

@section('title', 'Project Details')

@section('content')
<div class="container mt-5">
    <h1 class="text-primary mb-4">Project Details</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

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
                       ($invoice->project_status === 'reviewing' ? 'bg-warning' : 'bg-secondary') }}">
                    {{ ucfirst($invoice->project_status) }}
                </span>
            </td>
        </tr>
        <tr>
            <th>Progress:</th>
            <td>{{ $invoice->progress_percentage }}%</td>
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

    @if($invoice->project_status === 'reviewing')
        <form action="{{ route('admin.projects.finish', $invoice->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success mt-3" onclick="return confirm('Are you sure you want to mark this project as finished?')">
                Mark as Finished
            </button>
        </form>
    @endif

    <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
@endsection
