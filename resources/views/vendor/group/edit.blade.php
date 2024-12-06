@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3>Edit Service Group</h3>
    <form action="{{ route('vendor.groups.update', $group->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Group Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $group->name }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description">{{ $group->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="services" class="form-label">Select Services</label>
            <div>
                @foreach ($services as $service)
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="service_{{ $service->id }}" name="services[]" value="{{ $service->id }}"
                            @if ($service->group_id == $group->id) checked @endif>
                        <label class="form-check-label" for="service_{{ $service->id }}">{{ $service->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update Group</button>
    </form>
</div>
@endsection
