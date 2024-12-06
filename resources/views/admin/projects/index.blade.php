@extends('layouts.app')

@section('title', 'Project List')

@section('content')
<div class="container mt-5">
    <h1 class="text-primary mb-4">Project List</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table align-middle table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Service Name</th>
                    <th>Status</th>
                    <th>Progress</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                    <tr>
                        <!-- ID -->
                        <td>{{ $project->id }}</td>

                        <!-- Service Name -->
                        <td>
                            <strong>{{ $project->service_name }}</strong>
                        </td>

                        <!-- Status -->
                        <td>
                            <span class="badge 
                                {{ $project->project_status === 'finished' ? 'bg-success' : 
                                   ($project->project_status === 'reviewing' ? 'bg-warning' : 'bg-secondary') }} p-2">
                                {{ ucfirst($project->project_status) }}
                            </span>
                        </td>

                        <!-- Progress -->
                        <td>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar 
                                    {{ $project->progress_percentage == 100 ? 'bg-success' : 'bg-info' }}" 
                                    role="progressbar" 
                                    style="width: {{ $project->progress_percentage }}%;" 
                                    aria-valuenow="{{ $project->progress_percentage }}" 
                                    aria-valuemin="0" 
                                    aria-valuemax="100">
                                    {{ $project->progress_percentage }}%
                                </div>
                            </div>
                        </td>

                        <!-- Last Updated -->
                        <td>{{ $project->updated_at->format('d M Y H:i') }}</td>

                        <!-- Actions -->
                        <td>
                            <a href="{{ route('admin.projects.show', $project->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i> Details
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
