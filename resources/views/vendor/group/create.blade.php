@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3>Create Service Group</h3>
    <form action="{{ route('vendor.groups.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Group Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <div class="mb-3">
            <label for="services" class="form-label">Select Services</label>
            <div>
                @foreach ($services as $service)
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="service_{{ $service->id }}" name="services[]" value="{{ $service->id }}">
                        <label class="form-check-label" for="service_{{ $service->id }}">{{ $service->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Create Group</button>
    </form>
</div>
@endsection
