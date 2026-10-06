@extends('frontend.layouts.app')

@section('title', 'Submit Sample - COAVerify™')
@section('meta_description', 'Submit sample label image, product details, batch number, and optional COA file for COAVerify™ purity verification.')

@push('styles')
<style>
    .submit-page {
        padding: 80px 0;
    }

    .submit-grid {
        display: grid;
        grid-template-columns: .9fr 1.1fr;
        gap: 28px;
        align-items: start;
    }

    .info-panel,
    .submit-form-card {
        border: 1px solid rgba(215,181,109,.34);
        background:
            linear-gradient(180deg, rgba(255,255,255,.055), rgba(255,255,255,.018));
        border-radius: 30px;
        padding: 34px;
        box-shadow: 0 26px 80px rgba(0,0,0,.34);
    }

    .info-panel h1 {
        margin: 0 0 16px;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(36px, 5vw, 58px);
        line-height: 1.05;
    }

    .info-panel h1 span {
        color: var(--gold-light);
    }

    .info-panel p {
        color: var(--muted);
        line-height: 1.8;
        font-size: 17px;
        margin: 0 0 24px;
    }

    .process-list {
        display: grid;
        gap: 14px;
        margin-top: 26px;
    }

    .process-item {
        display: flex;
        gap: 14px;
        padding: 18px;
        border: 1px solid rgba(215,181,109,.22);
        border-radius: 20px;
        background: rgba(0,0,0,.25);
    }

    .process-item b {
        width: 38px;
        height: 38px;
        flex: 0 0 38px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        background: rgba(215,181,109,.13);
        color: var(--gold-light);
        border: 1px solid rgba(215,181,109,.30);
    }

    .process-item strong {
        display: block;
        color: #fff;
        margin-bottom: 5px;
    }

    .process-item span {
        color: var(--muted);
        font-size: 14px;
        line-height: 1.5;
    }

    .form-title {
        margin-bottom: 24px;
    }

    .form-title h2 {
        margin: 0 0 8px;
        color: var(--gold-light);
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 34px;
    }

    .form-title p {
        margin: 0;
        color: var(--muted);
        line-height: 1.7;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        color: var(--gold-light);
        font-weight: 800;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        background: #050505;
        border: 1px solid rgba(255,255,255,.14);
        color: #fff;
        border-radius: 16px;
        padding: 15px 16px;
        outline: none;
        font-size: 15px;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: var(--gold);
    }

    .file-help {
        color: rgba(255,255,255,.55);
        display: block;
        margin-top: 7px;
        font-size: 12px;
        line-height: 1.5;
    }

    .payment-box {
        border: 1px solid rgba(215,181,109,.24);
        background: rgba(0,0,0,.22);
        border-radius: 22px;
        padding: 20px;
        margin: 6px 0 20px;
    }

    .payment-box h3 {
        margin: 0 0 10px;
        color: var(--gold-light);
        font-size: 22px;
    }

    .payment-summary {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        padding: 13px 0;
        border-bottom: 1px solid rgba(255,255,255,.09);
        color: var(--muted);
        line-height: 1.5;
    }

    .payment-summary strong {
        color: var(--gold-light);
        white-space: nowrap;
    }

    .payment-methods {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        margin-top: 16px;
    }

    .payment-method {
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 18px;
        padding: 16px;
        background: rgba(255,255,255,.035);
    }

    .payment-method label {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #fff;
        margin-bottom: 12px;
        cursor: pointer;
    }

    .payment-method input[type="radio"] {
        width: auto;
    }

    .payment-method img {
        display: block;
        width: 160px;
        height: 160px;
        object-fit: contain;
        border-radius: 14px;
        padding: 8px;
        background: #fff;
        margin: 10px 0;
    }

    .payment-method p {
        margin: 8px 0 0;
        color: var(--muted);
        line-height: 1.6;
        font-size: 13px;
    }

    .payment-pill {
        display: inline-flex;
        max-width: 100%;
        margin-top: 8px;
        padding: 8px 10px;
        border-radius: 999px;
        border: 1px solid rgba(215,181,109,.24);
        color: var(--gold-light);
        background: rgba(215,181,109,.08);
        overflow-wrap: anywhere;
        line-height: 1.4;
        font-size: 13px;
        font-weight: 800;
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

    .submit-note {
        color: rgba(255,255,255,.55);
        line-height: 1.7;
        font-size: 13px;
        margin-top: 16px;
    }

    @media(max-width: 900px) {
        .submit-grid,
        .form-row,
        .payment-methods {
            grid-template-columns: 1fr;
        }

        .submit-page {
            padding: 55px 0;
        }

        .info-panel,
        .submit-form-card {
            padding: 24px;
        }
    }
</style>
@endpush

@section('content')

@php
    $paymentMethods = $paymentMethods ?? [];
    $cart = $cart ?? session()->get('cart', ['items' => [], 'subtotal' => 0, 'currency' => 'USD']);
    $cartSubtotal = (float) ($cart['subtotal'] ?? 0);
    $cartCurrency = $cart['currency'] ?? 'USD';
@endphp

<section class="submit-page">
    <div class="container">
        <div class="submit-grid">

            <div class="info-panel">
                <div class="premium-badge">Sample Submission</div>

                <h1>
                    Submit Product Details for <span>COA Verification</span>
                </h1>

                <p>
                    Upload the product label image, batch information, and optional COA file.
                    COAVerify™ will review the submitted details and prepare the record for
                    purity verification workflow.
                </p>

                <div class="process-list">
                    <div class="process-item">
                        <b>1</b>
                        <div>
                            <strong>Upload Sample Label</strong>
                            <span>Attach a clear product label image showing product and batch details.</span>
                        </div>
                    </div>

                    <div class="process-item">
                        <b>2</b>
                        <div>
                            <strong>Enter Batch Information</strong>
                            <span>Add product name, batch number, strength, company, and contact details.</span>
                        </div>
                    </div>

                    <div class="process-item">
                        <b>3</b>
                        <div>
                            <strong>Verification Review</strong>
                            <span>The submitted record will be reviewed for the COAVerify™ workflow.</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="submit-form-card">
                <div class="form-title">
                    <h2>Sample Details</h2>
                    <p>
                        Please provide accurate information to avoid delays in verification processing.
                    </p>
                </div>

                @if(session('success'))
                    <div class="alert-box alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert-box alert-error">
                        <strong>Please fix the following:</strong><br>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('sample.submit.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label>Company Name *</label>
                            <input type="text" name="company_name" value="{{ old('company_name') }}" placeholder="Example: Elite Pharm USA" required>
                        </div>

                        <div class="form-group">
                            <label>Contact Name</label>
                            <input type="text" name="contact_name" value="{{ old('contact_name') }}" placeholder="Your name">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Email Address *</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required>
                        </div>

                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+1 000 000 0000">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Product Name *</label>
                            <input type="text" name="product_name" value="{{ old('product_name') }}" placeholder="Example: Retatrutide" required>
                        </div>

                        <div class="form-group">
                            <label>Strength</label>
                            <input type="text" name="strength" value="{{ old('strength') }}" placeholder="Example: 30mg / 80mg">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Batch Number</label>
                        <input type="text" name="batch_number" value="{{ old('batch_number') }}" placeholder="Example: EP0861">
                    </div>

                    <div class="form-group">
                        <label>Sample Label Image</label>
                        <input type="file" name="sample_label_image" accept=".jpg,.jpeg,.png,.webp">
                        <small class="file-help">
                            Upload label image like KLOW / Retatrutide sample label. Allowed: JPG, PNG, WEBP. Max 10MB.
                        </small>
                    </div>

                    <div class="form-group">
                        <label>Optional COA / Supporting File</label>
                        <input type="file" name="coa_file" accept=".pdf,.jpg,.jpeg,.png,.webp">
                        <small class="file-help">
                            Optional file upload. Allowed: PDF, JPG, PNG, WEBP. Max 10MB.
                        </small>
                    </div>

                    @if($cartSubtotal > 0 || !empty($paymentMethods))
                        <div class="payment-box">
                            <h3>Payment Details</h3>

                            @if($cartSubtotal > 0)
                                <div class="payment-summary">
                                    <span>Cart Total</span>
                                    <strong>{{ $cartCurrency }} {{ number_format($cartSubtotal, 2) }}</strong>
                                </div>
                            @else
                                <p style="color:var(--muted);line-height:1.7;margin:0;">
                                    Select a payment option below if admin has shared payment instructions for your submission.
                                </p>
                            @endif

                            @if(!empty($paymentMethods))
                                <div class="payment-methods">
                                    @foreach($paymentMethods as $index => $method)
                                        <div class="payment-method">
                                            <label>
                                                <input
                                                    type="radio"
                                                    name="payment_method_key"
                                                    value="{{ $index }}"
                                                    {{ (string) old('payment_method_key', $loop->first ? $index : '') === (string) $index ? 'checked' : '' }}
                                                    {{ $cartSubtotal > 0 ? 'required' : '' }}
                                                >
                                                <strong>{{ $method['label'] }}</strong>
                                            </label>

                                            @if(!empty($method['qr_image']))
                                                <img src="{{ asset('storage/' . $method['qr_image']) }}" alt="{{ $method['label'] }} QR">
                                            @elseif(!empty($method['generated_qr_base64']))
                                                <img src="{{ $method['generated_qr_base64'] }}" alt="{{ $method['label'] }} QR">
                                            @endif

                                            @if(!empty($method['upi_id']))
                                                <span class="payment-pill">UPI: {{ $method['upi_id'] }}</span>
                                            @endif

                                            @if(!empty($method['payment_link']))
                                                <a href="{{ $method['payment_link'] }}" target="_blank" rel="noopener" class="payment-pill">
                                                    Open Payment Link
                                                </a>
                                            @elseif(!empty($method['generated_payment_link']))
                                                <a href="{{ $method['generated_payment_link'] }}" class="payment-pill">
                                                    Open UPI App
                                                </a>
                                            @endif

                                            @if(!empty($method['instructions']))
                                                <p>{{ $method['instructions'] }}</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p style="color:var(--muted);line-height:1.7;margin:14px 0 0;">
                                    Payment methods are not configured yet. Please submit your details and our team will contact you.
                                </p>
                            @endif

                            <div class="form-row" style="margin-top:18px;">
                                <div class="form-group">
                                    <label>Payment Reference / Transaction ID</label>
                                    <input type="text" name="payment_reference" value="{{ old('payment_reference') }}" placeholder="Example: UTR / transaction ID">
                                </div>

                                <div class="form-group">
                                    <label>Payment Proof {{ $cartSubtotal > 0 && !empty($paymentMethods) ? '*' : '' }}</label>
                                    <input
                                        type="file"
                                        name="payment_proof_file"
                                        accept=".pdf,.jpg,.jpeg,.png,.webp"
                                        {{ $cartSubtotal > 0 && !empty($paymentMethods) ? 'required' : '' }}
                                    >
                                    <small class="file-help">
                                        Upload payment screenshot or receipt. Allowed: PDF, JPG, PNG, WEBP. Max 10MB.
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label>Notes</label>
                        <textarea name="notes" rows="5" placeholder="Add any additional instructions or product details.">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Submit Sample for Review
                    </button>

                    <p class="submit-note">
                        COAVerify™ facilitates independent third-party analytical verification through partner laboratory networks.
                        Submitted files are used only for verification record review and processing.
                    </p>
                </form>
            </div>

        </div>
    </div>
</section>

@endsection
