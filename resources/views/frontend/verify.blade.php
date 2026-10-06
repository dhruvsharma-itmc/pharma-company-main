@extends('frontend.layouts.app')

@section('title', 'Verify Batch - COAVerify™')
@section('meta_description', 'Verify COAVerify™ batch authenticity using secure batch number authentication.')

@push('styles')
<style>
    .verify-page {
        padding: 75px 0 95px;
    }

    .verify-hero {
        text-align: center;
        max-width: 900px;
        margin: 0 auto 42px;
    }

    .verify-hero h1 {
        margin: 0 0 16px;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(42px, 6vw, 76px);
        line-height: 1;
    }

    .verify-hero h1 span {
        color: var(--gold-light);
    }

    .verify-hero p {
        margin: 0 auto;
        max-width: 760px;
        color: var(--muted);
        font-size: 18px;
        line-height: 1.8;
    }

    .verify-grid {
        display: grid;
        grid-template-columns: .9fr 1.1fr;
        gap: 28px;
        align-items: start;
    }

    .verify-card,
    .result-card,
    .info-card {
        border: 1px solid rgba(215,181,109,.34);
        border-radius: 30px;
        background:
            radial-gradient(circle at top left, rgba(215,181,109,.13), transparent 36%),
            linear-gradient(180deg, rgba(255,255,255,.055), rgba(255,255,255,.018));
        box-shadow: 0 26px 80px rgba(0,0,0,.32);
    }

    .verify-card {
        padding: 34px;
    }

    .verify-card h2 {
        margin: 0 0 10px;
        color: var(--gold-light);
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 34px;
    }

    .verify-card p {
        color: var(--muted);
        line-height: 1.7;
        margin: 0 0 24px;
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
        padding: 16px 18px;
        outline: none;
        font-size: 16px;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .form-group input:focus {
        border-color: var(--gold);
    }

    .example-list {
        margin-top: 22px;
        display: grid;
        gap: 12px;
    }

    .example-batch {
        padding: 14px 16px;
        border-radius: 16px;
        border: 1px solid rgba(215,181,109,.22);
        background: rgba(0,0,0,.25);
        display: flex;
        justify-content: space-between;
        gap: 14px;
        color: var(--muted);
        font-size: 14px;
    }

    .example-batch strong {
        color: var(--gold-light);
    }

    .result-card {
        overflow: hidden;
    }

    .result-header {
        padding: 28px;
        border-bottom: 1px solid rgba(215,181,109,.24);
        display: flex;
        justify-content: space-between;
        gap: 18px;
        align-items: center;
        flex-wrap: wrap;
        background: rgba(0,0,0,.22);
    }

    .result-header h2 {
        margin: 0;
        color: #fff;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 32px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 15px;
        border-radius: 999px;
        font-weight: 900;
        font-size: 13px;
    }

    .status-verified {
        background: rgba(34,197,94,.12);
        border: 1px solid rgba(34,197,94,.30);
        color: #86efac;
    }

    .status-pending {
        background: rgba(250,204,21,.12);
        border: 1px solid rgba(250,204,21,.30);
        color: #fde68a;
    }

    .status-revoked,
    .status-not-found {
        background: rgba(239,68,68,.12);
        border: 1px solid rgba(239,68,68,.30);
        color: #fecaca;
    }

    .result-body {
        padding: 28px;
    }

    .result-main {
        display: grid;
        grid-template-columns: 1fr 220px;
        gap: 24px;
        align-items: stretch;
    }

    .result-lines {
        display: grid;
        gap: 12px;
    }

    .result-line {
        display: flex;
        justify-content: space-between;
        gap: 18px;
        padding: 14px 0;
        border-bottom: 1px solid rgba(255,255,255,.08);
        color: var(--muted);
    }

    .result-line strong {
        color: #fff;
        text-align: right;
    }

    .purity-box {
        border: 1px solid rgba(215,181,109,.30);
        border-radius: 24px;
        padding: 24px;
        background:
            radial-gradient(circle at top, rgba(215,181,109,.18), transparent 55%),
            #070707;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
    }

    .purity-box span {
        color: var(--muted);
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        margin-bottom: 10px;
    }

    .purity-box strong {
        color: var(--gold-light);
        font-size: 48px;
        line-height: 1;
    }

    .report-actions {
        margin-top: 24px;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .not-found-box {
        padding: 34px;
        text-align: center;
    }

    .not-found-box h2 {
        margin: 0 0 14px;
        color: #fecaca;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 34px;
    }

    .not-found-box p {
        color: var(--muted);
        line-height: 1.8;
        margin: 0 auto 22px;
        max-width: 640px;
    }

    .info-card {
        margin-top: 28px;
        padding: 28px;
    }

    .info-card h3 {
        margin: 0 0 14px;
        color: var(--gold-light);
        font-size: 24px;
    }

    .info-list {
        display: grid;
        gap: 13px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .info-list li {
        color: var(--muted);
        line-height: 1.6;
        padding-left: 28px;
        position: relative;
    }

    .info-list li:before {
        content: "✓";
        position: absolute;
        left: 0;
        color: var(--gold-light);
        font-weight: 900;
    }

    .alert-error {
        padding: 14px 16px;
        border-radius: 16px;
        margin-bottom: 18px;
        background: rgba(239,68,68,.12);
        border: 1px solid rgba(239,68,68,.28);
        color: #fecaca;
    }

    @media(max-width: 950px) {
        .verify-grid,
        .result-main {
            grid-template-columns: 1fr;
        }

        .result-line {
            flex-direction: column;
            gap: 5px;
        }

        .result-line strong {
            text-align: left;
        }
    }
</style>
@endpush

@section('content')

<section class="verify-page">
    <div class="container">
        <div class="verify-hero">
            <div class="premium-badge">Secure Batch Authentication</div>

            <h1>Verify Your <span>Batch</span></h1>

            <p>
                Enter the batch number printed on the product label to confirm COAVerify™
                verification status, product details, purity percentage, company name, and verification date.
            </p>
        </div>

        <div class="verify-grid">
            <div>
                <div class="verify-card">
                    <h2>Batch Lookup</h2>

                    <p>
                        Use exact batch number from the product label.
                        Example: EP0861 or EP0862.
                    </p>

                    @if($errors->any())
                        <div class="alert-error">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verify.check') }}">
                        @csrf

                        <div class="form-group">
                            <label>Batch Number *</label>
                            <input
                                type="text"
                                name="batch_number"
                                value="{{ old('batch_number', $batchNumber) }}"
                                placeholder="EP0861"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-primary" style="width:100%;">
                            Verify Batch
                        </button>
                    </form>

                    <div class="example-list">
                        <div class="example-batch">
                            <span>Demo Batch</span>
                            <strong>EP0861</strong>
                        </div>

                        <div class="example-batch">
                            <span>Demo Batch</span>
                            <strong>EP0862</strong>
                        </div>
                    </div>
                </div>

                <div class="info-card">
                    <h3>What This Verifies</h3>

                    <ul class="info-list">
                        <li>Batch authenticity through exact batch number lookup.</li>
                        <li>Verified product name and strength information.</li>
                        <li>Purity percentage from the COAVerify™ verification record.</li>
                        <li>Client company name and verification date.</li>
                    </ul>
                </div>
            </div>

            <div>
                @if($searched && $report)
                    <div class="result-card">
                        <div class="result-header">
                            <h2>COAVerify™ Result</h2>

                            @if($report->status === 'verified')
                                <span class="status-badge status-verified">Verified ✅</span>
                            @elseif($report->status === 'pending')
                                <span class="status-badge status-pending">Pending Review</span>
                            @else
                                <span class="status-badge status-revoked">Record Revoked</span>
                            @endif
                        </div>

                        <div class="result-body">
                            <div class="result-main">
                                <div class="result-lines">
                                    <div class="result-line">
                                        <span>Batch Number</span>
                                        <strong>{{ $report->batch_number }}</strong>
                                    </div>

                                    <div class="result-line">
                                        <span>Product Name</span>
                                        <strong>{{ $report->product_name }}</strong>
                                    </div>

                                    <div class="result-line">
                                        <span>Strength</span>
                                        <strong>{{ $report->strength ?: 'N/A' }}</strong>
                                    </div>

                                    <div class="result-line">
                                        <span>Company Name</span>
                                        <strong>{{ $report->client_company_name }}</strong>
                                    </div>

                                    <div class="result-line">
                                        <span>Verification Date</span>
                                        <strong>
                                            {{ $report->verification_date ? $report->verification_date->format('d M Y') : 'N/A' }}
                                        </strong>
                                    </div>

                                    <div class="result-line">
                                        <span>Verification Status</span>
                                        <strong>{{ ucfirst($report->status) }}</strong>
                                    </div>
                                </div>

                                <div class="purity-box">
                                    <span>Verified Purity</span>

                                    <strong>
                                        @if(!is_null($report->purity_percent))
                                            {{ number_format((float) $report->purity_percent, 2) }}%
                                        @else
                                            N/A
                                        @endif
                                    </strong>
                                </div>
                            </div>

                            <div class="report-actions">
                                @if($report->report_pdf)
                                    <a href="{{ asset('storage/' . $report->report_pdf) }}" target="_blank" class="btn btn-primary">
                                        Download COAVerify™ Report
                                    </a>
                                @endif

                                <a href="{{ route('verify.index') }}" class="btn btn-outline">
                                    Verify Another Batch
                                </a>
                                @if($report->status === 'verified')
                                    <a href="{{ route('verify.report.download', $report) }}" class="btn btn-primary">
                                        Download Label Report
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @elseif($searched && !$report)
                    <div class="result-card">
                        <div class="not-found-box">
                            <span class="status-badge status-not-found">Not Verified</span>

                            <h2>No Verified Record Found</h2>

                            <p>
                                We could not find a COAVerify™ record for batch number
                                <strong style="color:#fff;">{{ $batchNumber }}</strong>.
                                Please check the batch number and try again.
                            </p>

                            <a href="{{ route('sample.submit') }}" class="btn btn-primary">
                                Submit Sample for Review
                            </a>
                        </div>
                    </div>
                @else
                    <div class="result-card">
                        <div class="not-found-box">
                            <span class="status-badge status-verified">Ready to Verify</span>

                            <h2>Enter a Batch Number</h2>

                            <p>
                                Your verification result will appear here after entering a valid batch number.
                                The result will show product name, purity percentage, company name, date, and status.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection