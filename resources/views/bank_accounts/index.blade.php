

@extends('layouts.app') <!-- Menggunakan layout utama -->

@section('title', 'Bank Account Manager')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Bank Account Manager</h4>

            

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Bank Name</th>
                            <th>Account Number</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accounts as $index => $account)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $account->bank_name }}</td>
                                <td>{{ $account->account_number }}</td>
                                <td>{{ $account->description }}</td>
                                <td>
                                    @if ($account->image)
                                        <img src="{{ asset('storage/' . $account->image) }}" alt="Bank Image" width="50">
                                    @else
                                        No Image
                                    @endif
                                </td>
                                <td>
                                    <!-- Edit Button -->
                                    <a href="{{ route('bank_accounts.edit', $account->id) }}" class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <!-- Delete Form -->
                                    <form action="{{ route('bank_accounts.destroy', $account->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this account?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Button to Add New Bank Account -->
            <a href="{{ route('bank_accounts.create') }}" class="btn btn-primary mt-3">Add New Bank Account</a>
        </div>
    </div>
</div>
@endsection

