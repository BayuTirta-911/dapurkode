@extends('layouts.app')

@section('content')


</style>
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Invoice</h5>

            <form method="POST" action="{{ route('invoice.applyDiscount', $service->id) }}?aff={{ request()->query('aff') }}">
                @csrf

                <table class="table">
                    <tr>
                        <td>Service : {{ $service->name }}</td>
                        <td>Rp {{ number_format($og_price) }}</td>
                    </tr>

                    <!-- Diskon -->
                    @if(session('discount_amount'))
                    <tr>
                        <td>Discount</td>
                        <td>- Rp {{ number_format(session('discount_amount')) }}</td>
                    </tr>
                    @endif

                    <tr>
                        <th>Total</th>
                        <th>
                            Rp {{ number_format($og_price - session('discount_amount')); }}
                        </th>
                    </tr>
                </table>

                <!-- Diskon -->
                <h5>Code Diskon (Optional)</h5>
                <div class="input-group mb-3">
                    <input type="text" name="discount_code" class="form-control" placeholder="Masukkan kode diskon" value="{{ old('discount_code') }}">
                    <button type="submit" class="btn btn-primary">Input Discount</button>
                </div>

                <!-- Affiliate Code -->
                <h5>Code Affiliate</h5>
                <div class="input-group mb-3">
                    <input type="text" name="affiliate_code" class="form-control" placeholder="No Affiliate Code" value="{{ old('affiliate_code', $affiliateCode) }}" disabled>
                </div>
            </form>

            @if(auth()->check())
                <!-- Jika User Sudah Login -->
                <form method="POST" action="{{ route('invoice.process', $service->id) }}">
                    @csrf
                    <h5>Informasi Pemesanan</h5>
                    <input type="hidden" name="affiliate_code" value="{{ old('affiliate_code', $affiliateCode) }}">
                    <input type="hidden" name="summary" value="{{ number_format($og_price - session('discount_amount')) }}">
                    <input type="hidden" name="og_price" value="{{ number_format($og_price) }}">
                    <input type="hidden" name="og_disc" value="{{ number_format(session('discount_true_amount')) }}">
                    <div class="mb-3">
                        <label>Alamat</label>
                        <textarea name="address" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label>No. Telepon Cadangan</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Catatan</label>
                        <textarea name="note" class="form-control"></textarea>
                    </div>

                    <h5>Pilih Metode Pembayaran</h5>
                    <div class="container mt-4">
                        <div class="row g-3">
                            @foreach($banks as $bank)
                                <div class="col-md-3">
                                    <div class="card p-2">
                                        <div class="d-flex align-items-center">
                                            <input class="form-check-input me-2" type="radio" name="bank" value="{{ $bank->id }}" required>
                                            <img src="{{ asset('storage/' . $bank->image) }}" alt="{{ $bank->name }}" class="img-fluid" style="width: 150px; height: auto; margin-right: 10px;">
                                            <div>{{ $bank->name }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 mt-4">Proses</button>
                </form>
            @else
                <!-- Jika User Belum Login -->
                <div class="alert alert-info mt-4">
                    <p>You need to be logged in to continue.</p>
                </div>

                <!-- Login dan Register Form -->
                <ul class="nav nav-tabs" id="login-register-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="true">Login</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="false">Register</button>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="login-register-content">
                    <!-- Login Form -->
                    <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <input type="hidden" name="redirect" value="{{ url()->full() }}">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>

                    <!-- Register Form -->
                    <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <input type="hidden" name="redirect" value="{{ url()->full() }}">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
                            </div>
                            <button type="submit" class="btn btn-success">Register</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
