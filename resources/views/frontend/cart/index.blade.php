@extends('frontend.layouts.app')

@section('title', 'Cart - COAVerify™')
@section('meta_description', 'Review selected COAVerify™ sample verification services and additional services.')

@push('styles')
<style>
    .cart-page {
        padding: 70px 0 90px;
    }

    .cart-header {
        margin-bottom: 28px;
        text-align: center;
    }

    .cart-header h1 {
        margin: 0 0 14px;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(38px, 5vw, 64px);
    }

    .cart-header p {
        color: var(--muted);
        line-height: 1.7;
        margin: 0;
    }

    .cart-grid {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 24px;
        align-items: start;
    }

    .cart-panel {
        border: 1px solid rgba(215,181,109,.34);
        border-radius: 30px;
        padding: 28px;
        background:
            linear-gradient(180deg, rgba(255,255,255,.055), rgba(255,255,255,.018));
        box-shadow: 0 26px 80px rgba(0,0,0,.32);
    }

    .cart-item {
        padding: 22px;
        border: 1px solid rgba(215,181,109,.22);
        border-radius: 22px;
        background: rgba(0,0,0,.24);
        margin-bottom: 16px;
    }

    .cart-item:last-child {
        margin-bottom: 0;
    }

    .cart-item-head {
        display: flex;
        justify-content: space-between;
        gap: 18px;
        align-items: start;
        margin-bottom: 16px;
    }

    .cart-item h3 {
        margin: 0 0 6px;
        color: #fff;
        font-size: 24px;
    }

    .cart-item p {
        margin: 0;
        color: var(--muted);
    }

    .cart-price {
        color: var(--gold-light);
        font-size: 24px;
        font-weight: 900;
        white-space: nowrap;
    }

    .addon-list {
        margin-top: 14px;
        border-top: 1px solid rgba(255,255,255,.08);
        padding-top: 14px;
        display: grid;
        gap: 8px;
    }

    .addon-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        color: var(--muted);
        font-size: 14px;
    }

    .addon-row strong {
        color: #fff;
    }

    .remove-btn {
        margin-top: 16px;
        border: 1px solid rgba(239,68,68,.28);
        background: rgba(239,68,68,.12);
        color: #fecaca;
        border-radius: 999px;
        padding: 10px 15px;
        cursor: pointer;
        font-weight: 800;
    }

    .summary-box h2 {
        margin: 0 0 18px;
        color: var(--gold-light);
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 30px;
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid rgba(255,255,255,.08);
        color: var(--muted);
    }

    .summary-line strong {
        color: #fff;
    }

    .total-line {
        margin-top: 18px;
        padding-top: 18px;
        border-top: 1px solid rgba(215,181,109,.28);
        display: flex;
        justify-content: space-between;
        gap: 12px;
    }

    .total-line span {
        color: #fff;
        font-size: 18px;
        font-weight: 900;
    }

    .total-line strong {
        color: var(--gold-light);
        font-size: 26px;
    }

    .empty-cart {
        text-align: center;
        padding: 45px 20px;
        color: var(--muted);
        line-height: 1.8;
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

    .payment-preview {
        margin-top: 20px;
        padding-top: 18px;
        border-top: 1px solid rgba(215,181,109,.22);
        display: grid;
        gap: 12px;
    }

    .payment-preview h3 {
        margin: 0;
        color: var(--gold-light);
        font-size: 18px;
    }

    .payment-preview-item {
        border: 1px solid rgba(255,255,255,.10);
        border-radius: 16px;
        padding: 13px;
        background: rgba(0,0,0,.18);
    }

    .payment-preview-item strong {
        display: block;
        color: #fff;
        margin-bottom: 8px;
    }

    .payment-preview-item img {
        width: 120px;
        height: 120px;
        object-fit: contain;
        border-radius: 12px;
        padding: 7px;
        background: #fff;
        margin-bottom: 8px;
    }

    .payment-preview-item span,
    .payment-preview-item a {
        display: inline-flex;
        max-width: 100%;
        color: var(--gold-light);
        font-size: 12px;
        font-weight: 800;
        overflow-wrap: anywhere;
        line-height: 1.4;
    }

    @media(max-width: 900px) {
        .cart-grid {
            grid-template-columns: 1fr;
        }

        .cart-item-head {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')

<section class="cart-page">
    <div class="container">
        <div class="cart-header">
            <div class="premium-badge">Order Cart</div>

            <h1>Your Cart</h1>

            <p>
                Review selected sample verification services and optional add-ons before submitting sample details.
            </p>
        </div>

        @if(session('success'))
            <div class="alert-box alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="cart-grid">
            <div class="cart-panel">
                @if(!empty($cart['items']))
                    @foreach($cart['items'] as $cartKey => $cartItem)
                        <div class="cart-item">
                            <div class="cart-item-head">
                                <div>
                                    <h3>{{ $cartItem['service_title'] }}</h3>
                                    <p>{{ $cartItem['category_title'] }}</p>
                                </div>

                                <div class="cart-price">
                                    {{ $cartItem['currency'] }} {{ number_format((float) $cartItem['line_total'], 2) }}
                                </div>
                            </div>

                            <div class="addon-list">
                                <div class="addon-row">
                                    <span>Base Service</span>
                                    <strong>{{ $cartItem['currency'] }} {{ number_format((float) $cartItem['base_price'], 2) }}</strong>
                                </div>

                                @foreach($cartItem['additional_services'] as $addon)
                                    <div class="addon-row">
                                        <span>{{ $addon['title'] }}</span>
                                        <strong>{{ $addon['currency'] }} {{ number_format((float) $addon['price'], 2) }}</strong>
                                    </div>
                                @endforeach
                            </div>

                            <form method="POST" action="{{ route('cart.remove', $cartKey) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="remove-btn">Remove</button>
                            </form>
                        </div>
                    @endforeach
                @else
                    <div class="empty-cart">
                        Your cart is currently empty.<br>
                        Browse services and add a sample verification option to continue.
                        <br><br>
                        <a href="{{ route('services.index') }}" class="btn btn-primary">Browse Services</a>
                    </div>
                @endif
            </div>

            <div class="cart-panel summary-box">
                <h2>Order Summary</h2>

                <div class="summary-line">
                    <span>Total Items</span>
                    <strong>{{ count($cart['items'] ?? []) }}</strong>
                </div>

                <div class="summary-line">
                    <span>Currency</span>
                    <strong>{{ $cart['currency'] ?? 'USD' }}</strong>
                </div>

                <div class="total-line">
                    <span>Subtotal</span>
                    <strong>{{ $cart['currency'] ?? 'USD' }} {{ number_format((float) ($cart['subtotal'] ?? 0), 2) }}</strong>
                </div>

                @if(!empty($cart['items']) && !empty($paymentMethods))
                    <div class="payment-preview">
                        <h3>Payment Options</h3>

                        @foreach($paymentMethods as $method)
                            <div class="payment-preview-item">
                                <strong>{{ $method['label'] }}</strong>

                                @if(!empty($method['qr_image']))
                                    <img src="{{ asset('storage/' . $method['qr_image']) }}" alt="{{ $method['label'] }} QR">
                                @elseif(!empty($method['generated_qr_base64']))
                                    <img src="{{ $method['generated_qr_base64'] }}" alt="{{ $method['label'] }} QR">
                                @endif

                                @if(!empty($method['upi_id']))
                                    <span>UPI: {{ $method['upi_id'] }}</span>
                                @endif

                                @if(!empty($method['payment_link']))
                                    <a href="{{ $method['payment_link'] }}" target="_blank" rel="noopener">
                                        Open Payment Link
                                    </a>
                                @elseif(!empty($method['generated_payment_link']))
                                    <a href="{{ $method['generated_payment_link'] }}">
                                        Open UPI App
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                <div style="display:grid;gap:12px;margin-top:24px;">
                    <a href="{{ route('sample.submit') }}" class="btn btn-primary">
                        Proceed to Submit Sample
                    </a>

                    <a href="{{ route('services.index') }}" class="btn btn-outline">
                        Add More Services
                    </a>

                    @if(!empty($cart['items']))
                        <form method="POST" action="{{ route('cart.clear') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline" style="width:100%;">
                                Clear Cart
                            </button>
                        </form>
                    @endif
                </div>

                <p style="color:var(--muted);line-height:1.7;font-size:13px;margin-top:18px;">
                    After cart selection, submit sample details and upload the label image / supporting file.
                </p>
            </div>
        </div>
    </div>
</section>

@endsection
