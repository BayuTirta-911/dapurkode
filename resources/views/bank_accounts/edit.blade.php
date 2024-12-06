
@extends('layouts.app')

@section('title', 'Edit Bank Account')

@section('content')
<div class="container mt-4">
    <h1>Edit Bank Account</h1>

    <form action="{{ route('bank_accounts.update', $bankAccount->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="bank_name" class="form-label">Bank Name</label>
            <input type="text" name="bank_name" class="form-control" value="{{ old('bank_name', $bankAccount->bank_name) }}" required>
        </div>

        <div class="mb-3">
            <label for="account_number" class="form-label">Account Number</label>
            <input type="text" name="account_number" class="form-control" value="{{ old('account_number', $bankAccount->account_number) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description', $bankAccount->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Bank Image</label>
            @if ($bankAccount->image)
                <div class="mb-2">
                    <p>Current Image:</p>
                    <img src="{{ asset('storage/' . $bankAccount->image) }}" alt="Bank Image" width="100">
                </div>
            @endif
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
@endsection

