@extends('layouts.app')

@section('title', 'Create Discount')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Create New Discount</h4>

            

            <form action="{{ route('admin.discounts.store') }}" method="POST">
                @csrf

                <!-- Input Kode Diskon -->
                <div class="mb-3">
                    <label for="code" class="form-label">Discount Code</label>
                    <input type="text" name="code" id="code" class="form-control" value="{{ old('code') }}" required>
                </div>

                <!-- Input Nominal Diskon -->
                <div class="mb-3">
                    <label for="amount" class="form-label">Discount Amount</label>
                    <input type="number" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" step="0.01" min="0" required>
                </div>

                <!-- Pilihan Services dengan Checkbox -->
                <div class="mb-3">
                    <label for="service_ids" class="form-label">Select Services</label>
                    <script>
                            function toggle(source) {
                            checkboxes = document.getElementsByName('service_ids[]');
                            for(var i=0, n=checkboxes.length;i<n;i++) {
                                checkboxes[i].checked = source.checked;
                            }
                            }
                        </script>
                        <div class="col-md-4">
                        <input class="form-check-input" type="checkbox" onClick="toggle(this)" /> Toggle All<br/>    
                        </div><br>
                    <div class="row">
                        
                        @foreach ($services as $service)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="service_ids[]" value="{{ $service->id }}" id="service-{{ $service->id }}">
                                    <label class="form-check-label" for="service-{{ $service->id }}">
                                        {{ $service->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="btn btn-primary">Create Discount</button>
                <a href="{{ route('admin.discounts.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
