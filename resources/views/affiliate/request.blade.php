@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h3>Request to Join Affiliate</h3>

    

    <form action="{{ route('affiliate.request.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="self_description" class="form-label">Describe Yourself</label>
            <textarea class="form-control" id="self_description" name="self_description" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="marketing_plan" class="form-label">How Will You Market?</label>
            <textarea class="form-control" id="marketing_plan" name="marketing_plan" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Request</button>
    </form>
</div>
@endsection
