@extends('frontend.layouts.app')

@section('title', 'Customer Dashboard - COAVerify™')
@section('meta_description', 'Access your COAVerify sample submission dashboard, payment proof, and verification status.')

@push('styles')
<style>
    .dashboard-login-page {
        padding: 78px 0 92px;
    }

    .dashboard-login-grid {
        display: grid;
        grid-template-columns: .92fr 1.08fr;
        gap: 26px;
        align-items: start;
    }

    .dashboard-panel {
        border: 1px solid rgba(215,181,109,.34);
        border-radius: 28px;
        padding: 32px;
        background: linear-gradient(180deg, rgba(255,255,255,.055), rgba(255,255,255,.018));
        box-shadow: 0 26px 80px rgba(0,0,0,.32);
    }

    .dashboard-panel h1,
    .dashboard-panel h2 {
        margin: 0 0 12px;
        color: #fff;
        font-family: Georgia, 'Times New Roman', serif;
        line-height: 1.08;
    }

    .dashboard-panel h1 {
        font-size: clamp(36px, 5vw, 58px);
    }

    .dashboard-panel h2 {
        color: var(--gold-light);
        font-size: 34px;
    }

    .dashboard-panel p {
        margin: 0;
        color: var(--muted);
        line-height: 1.75;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        color: var(--gold-light);
        font-weight: 900;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-group input {
        width: 100%;
        background: #050505;
        border: 1px solid rgba(255,255,255,.14);
        color: #fff;
        border-radius: 16px;
        padding: 15px 16px;
        outline: none;
        font-size: 15px;
    }

    .form-group input:focus {
        border-color: var(--gold);
    }

    .help {
        display: block;
        color: rgba(255,255,255,.52);
        font-size: 12px;
        line-height: 1.5;
        margin-top: 7px;
    }

    .alert-box {
        padding: 14px 16px;
        border-radius: 16px;
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .alert-success {
        background: rgba(34,197,94,.11);
        border: 1px solid rgba(34,197,94,.28);
        color: #bbf7d0;
    }

    .alert-error {
        background: rgba(239,68,68,.11);
        border: 1px solid rgba(239,68,68,.28);
        color: #fecaca;
    }

    @media(max-width: 900px) {
        .dashboard-login-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-panel {
            padding: 24px;
        }
    }
</style>
@endpush

@section('content')

<section class="dashboard-login-page">
    <div class="container">
        <div class="dashboard-login-grid">
            <div class="dashboard-panel">
                <div class="premium-badge">Customer Dashboard</div>
                <h1>Track Your Sample Review</h1>
                <p>
                    View submitted sample details, payment proof status, selected services,
                    and generated COA report once verification is completed.
                </p>
            </div>

            <div class="dashboard-panel">
                <h2>Access Dashboard</h2>

                @if(session('success'))
                    <div class="alert-box alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert-box alert-error">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('user.login.submit') }}">
                    @csrf

                    <div class="form-group">
                        <label>Email Address *</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required>
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+1 000 000 0000">
                    </div>

                    <div class="form-group">
                        <label>Batch Number</label>
                        <input type="text" name="batch_number" value="{{ old('batch_number') }}" placeholder="Example: EP0861">
                        <span class="help">Enter phone number or batch number along with your email.</span>
                    </div>

                    <button type="submit" class="btn btn-primary">Open Dashboard</button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
