@extends('layouts.app')

@section('title', 'Project List')

@section('content')
<div class="container mt-5">
    <h1 class="text-primary mb-4">Project List</h1>

    

    <!-- Tabel Proyek WIP -->
    <h3 class="text-secondary">Projects In Progress</h3>
    <div class="table-responsive mb-4">
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
                @forelse($projectsInProgress as $project)
                    <tr>
                        <!-- ID -->
                        <td>{{ $project->id }}</td>

                        <!-- Service Name -->
                        <td><strong>{{ $project->service_name }}</strong></td>

                        <!-- Status -->
                        <td>
                            <span class="badge bg-info p-2">{{ ucfirst($project->project_status) }}</span>
                        </td>

                        <!-- Progress -->
                        <td>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-info" role="progressbar" 
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
                            <a href="{{ route('project.progress.show', $project->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i> Details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No projects in progress.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Tabel Proyek Finished -->
    <h3 class="text-success">Finished Projects</h3>
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
                @forelse($projectsFinished as $project)
                    <tr>
                        <!-- ID -->
                        <td>{{ $project->id }}</td>

                        <!-- Service Name -->
                        <td><strong>{{ $project->service_name }}</strong></td>

                        <!-- Status -->
                        <td>
                            <span class="badge bg-success p-2">{{ ucfirst($project->project_status) }}</span>
                        </td>

                        <!-- Progress -->
                        <td>
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                     style="width: 100%;" 
                                     aria-valuenow="100" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    100%
                                </div>
                            </div>
                        </td>

                        <!-- Last Updated -->
                        <td>{{ $project->updated_at->format('d M Y H:i') }}</td>

                        <!-- Actions -->
                        <td>
                            <a href="{{ route('project.progress.show', $project->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i> Details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No finished projects.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
