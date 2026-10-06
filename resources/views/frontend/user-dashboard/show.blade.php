@extends('frontend.layouts.app')

@section('title', 'Submission Details - COAVerify™')
@section('meta_description', 'View your COAVerify submission details, payment proof, and COA report status.')

@push('styles')
<style>
    .submission-detail-page {
        padding: 58px 0 90px;
    }

    .detail-head {
        display: flex;
        justify-content: space-between;
        gap: 18px;
        align-items: end;
        margin-bottom: 22px;
    }

    .detail-head h1 {
        margin: 0;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(34px, 5vw, 56px);
    }

    .detail-head p {
        margin: 8px 0 0;
        color: var(--muted);
        line-height: 1.7;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 22px;
        align-items: start;
    }

    .detail-panel {
        border: 1px solid rgba(215,181,109,.28);
        border-radius: 24px;
        padding: 24px;
        background: linear-gradient(180deg, rgba(255,255,255,.052), rgba(255,255,255,.018));
        box-shadow: 0 18px 55px rgba(0,0,0,.24);
    }

    .detail-panel h2 {
        margin: 0 0 16px;
        color: var(--gold-light);
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 28px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .info-item {
        border: 1px solid rgba(255,255,255,.10);
        border-radius: 16px;
        padding: 14px;
        background: rgba(0,0,0,.18);
    }

    .info-item span {
        display: block;
        color: var(--muted);
        font-size: 12px;
        font-weight: 900;
        margin-bottom: 7px;
        text-transform: uppercase;
    }

    .info-item strong {
        display: block;
        color: #fff;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .cart-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .cart-table th,
    .cart-table td {
        border-bottom: 1px solid rgba(255,255,255,.09);
        padding: 12px 8px;
        text-align: left;
        color: var(--muted);
        vertical-align: top;
        font-size: 14px;
    }

    .cart-table th {
        color: var(--gold-light);
        font-size: 12px;
        text-transform: uppercase;
    }

    .cart-table strong {
        color: #fff;
    }

    .status-pill {
        display: inline-flex;
        border: 1px solid rgba(215,181,109,.28);
        border-radius: 999px;
        padding: 8px 11px;
        color: var(--gold-light);
        background: rgba(215,181,109,.08);
        font-size: 12px;
        font-weight: 900;
        margin: 4px 6px 4px 0;
    }

    .status-green {
        color: #bbf7d0;
        border-color: rgba(34,197,94,.30);
        background: rgba(34,197,94,.10);
    }

    .status-red {
        color: #fecaca;
        border-color: rgba(239,68,68,.30);
        background: rgba(239,68,68,.10);
    }

    .form-group {
        margin-bottom: 16px;
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
        padding: 14px 15px;
        outline: none;
        font-size: 15px;
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
        margin-bottom: 18px;
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

    @media(max-width: 920px) {
        .detail-head {
            display: grid;
            align-items: start;
        }

        .detail-grid,
        .info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

@php
    $cartSnapshot = $sampleSubmission->cart_snapshot ?? [];
@endphp

<section class="submission-detail-page">
    <div class="container">
        <div class="detail-head">
            <div>
                <div class="premium-badge">Submission #{{ $sampleSubmission->id }}</div>
                <h1>{{ $sampleSubmission->product_name }}</h1>
                <p>Batch {{ $sampleSubmission->batch_number ?: '-' }} · {{ $sampleSubmission->status_label }}</p>
            </div>

            <div style="display:flex;gap:10px;flex-wrap:wrap;">
                <a href="{{ route('user.dashboard') }}" class="btn btn-outline">Back to Dashboard</a>
                @if($coaReport && $coaReport->status === 'verified')
                    <a href="{{ route('verify.report.download', $coaReport) }}" target="_blank" class="btn btn-primary">Download COA</a>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="alert-box alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert-box alert-error">{{ $errors->first() }}</div>
        @endif

        <div class="detail-grid">
            <div style="display:grid;gap:22px;">
                <div class="detail-panel">
                    <h2>Sample Details</h2>

                    <div class="info-grid">
                        <div class="info-item">
                            <span>Company</span>
                            <strong>{{ $sampleSubmission->company_name }}</strong>
                        </div>
                        <div class="info-item">
                            <span>Contact</span>
                            <strong>{{ $sampleSubmission->contact_name ?: '-' }}</strong>
                        </div>
                        <div class="info-item">
                            <span>Email</span>
                            <strong>{{ $sampleSubmission->email }}</strong>
                        </div>
                        <div class="info-item">
                            <span>Phone</span>
                            <strong>{{ $sampleSubmission->phone ?: '-' }}</strong>
                        </div>
                        <div class="info-item">
                            <span>Strength</span>
                            <strong>{{ $sampleSubmission->strength ?: '-' }}</strong>
                        </div>
                        <div class="info-item">
                            <span>Submitted</span>
                            <strong>{{ $sampleSubmission->created_at ? $sampleSubmission->created_at->format('d M Y, h:i A') : '-' }}</strong>
                        </div>
                    </div>
                </div>

                @if(!empty($cartSnapshot['items']))
                    <div class="detail-panel">
                        <h2>Selected Services</h2>

                        <table class="cart-table">
                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Add-ons</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartSnapshot['items'] as $item)
                                    <tr>
                                        <td>
                                            <strong>{{ $item['service_title'] ?? '-' }}</strong><br>
                                            {{ $item['category_title'] ?? '-' }}
                                        </td>
                                        <td>
                                            @forelse(($item['additional_services'] ?? []) as $addon)
                                                {{ $addon['title'] ?? '-' }}<br>
                                            @empty
                                                -
                                            @endforelse
                                        </td>
                                        <td>
                                            <strong>
                                                {{ $item['currency'] ?? ($sampleSubmission->payment_currency ?: 'USD') }}
                                                {{ number_format((float) ($item['line_total'] ?? 0), 2) }}
                                            </strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <div class="detail-panel">
                    <h2>Uploaded Files</h2>

                    <div style="display:flex;gap:12px;flex-wrap:wrap;">
                        @if($sampleSubmission->sample_label_image)
                            <a href="{{ asset('storage/' . $sampleSubmission->sample_label_image) }}" target="_blank" class="btn btn-outline">View Label</a>
                        @endif

                        @if($sampleSubmission->coa_file)
                            <a href="{{ asset('storage/' . $sampleSubmission->coa_file) }}" target="_blank" class="btn btn-outline">View Supporting File</a>
                        @endif

                        @if(!$sampleSubmission->sample_label_image && !$sampleSubmission->coa_file)
                            <span class="status-pill">No files uploaded</span>
                        @endif
                    </div>
                </div>
            </div>

            <div style="display:grid;gap:22px;">
                <div class="detail-panel">
                    <h2>Status</h2>

                    <span class="status-pill">{{ $sampleSubmission->status_label }}</span>

                    @if($coaReport && $coaReport->status === 'verified')
                        <span class="status-pill status-green">COA Ready</span>
                    @else
                        <span class="status-pill">COA In Process</span>
                    @endif

                    @if($sampleSubmission->payment_proof_file)
                        <span class="status-pill status-green">Payment Proof Uploaded</span>
                    @elseif($sampleSubmission->payment_amount)
                        <span class="status-pill status-red">Payment Proof Pending</span>
                    @endif
                </div>

                <div class="detail-panel">
                    <h2>Payment</h2>

                    <div class="info-item" style="margin-bottom:14px;">
                        <span>Amount</span>
                        <strong>
                            {{ $sampleSubmission->payment_amount ? (($sampleSubmission->payment_currency ?: 'USD') . ' ' . number_format((float) $sampleSubmission->payment_amount, 2)) : '-' }}
                        </strong>
                    </div>

                    <div class="info-item" style="margin-bottom:14px;">
                        <span>Method</span>
                        <strong>{{ $sampleSubmission->payment_method_label ?: '-' }}</strong>
                    </div>

                    <div class="info-item" style="margin-bottom:18px;">
                        <span>Reference</span>
                        <strong>{{ $sampleSubmission->payment_reference ?: '-' }}</strong>
                    </div>

                    @if($sampleSubmission->payment_proof_file)
                        <a href="{{ asset('storage/' . $sampleSubmission->payment_proof_file) }}" target="_blank" class="btn btn-outline" style="margin-bottom:18px;">
                            View Current Proof
                        </a>
                    @endif

                    <form method="POST" action="{{ route('user.submissions.payment-proof', $sampleSubmission) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>Transaction / Reference ID</label>
                            <input type="text" name="payment_reference" value="{{ old('payment_reference', $sampleSubmission->payment_reference) }}" placeholder="UTR / transaction ID">
                        </div>

                        <div class="form-group">
                            <label>{{ $sampleSubmission->payment_proof_file ? 'Replace Payment Proof' : 'Upload Payment Proof' }}</label>
                            <input type="file" name="payment_proof_file" accept=".pdf,.jpg,.jpeg,.png,.webp" required>
                            <span class="help">Allowed: PDF, JPG, PNG, WEBP. Max 10MB.</span>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Payment Proof</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
