@extends('frontend.layouts.app')

@section('title', $item->title . ' - COAVerify™ Order')
@section('meta_description', $item->short_description ?: 'Order COAVerify™ sample review with optional additional services.')

@push('styles')
<style>
    .order-page {
        padding: 70px 0 90px;
    }

    .breadcrumb {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        color: rgba(255,255,255,.55);
        font-size: 14px;
        margin-bottom: 24px;
    }

    .breadcrumb a {
        color: var(--gold-light);
    }

    .order-grid {
        display: grid;
        grid-template-columns: 1.05fr .95fr;
        gap: 28px;
        align-items: start;
    }

    .order-card {
        border: 1px solid rgba(215,181,109,.34);
        border-radius: 30px;
        padding: 34px;
        background:
            radial-gradient(circle at top left, rgba(215,181,109,.14), transparent 36%),
            linear-gradient(180deg, rgba(255,255,255,.055), rgba(255,255,255,.018));
        box-shadow: 0 26px 80px rgba(0,0,0,.32);
    }

    .order-card h1 {
        margin: 0 0 14px;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(38px, 5vw, 62px);
        line-height: 1;
    }

    .order-card p {
        color: var(--muted);
        line-height: 1.8;
        font-size: 17px;
    }

    .price-box {
        margin-top: 24px;
        border: 1px solid rgba(215,181,109,.28);
        border-radius: 24px;
        padding: 24px;
        background: rgba(0,0,0,.28);
    }

    .price-box span {
        display: block;
        color: var(--muted);
        margin-bottom: 8px;
    }

    .price-box strong {
        color: var(--gold-light);
        font-size: 42px;
        font-weight: 900;
    }

    .params {
        display: grid;
        gap: 12px;
        margin-top: 24px;
    }

    .param-row {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        border-bottom: 1px solid rgba(255,255,255,.08);
        padding-bottom: 12px;
        color: var(--muted);
    }

    .param-row strong {
        color: #fff;
        text-align: right;
    }

    .additional-box {
        border: 1px solid rgba(215,181,109,.34);
        border-radius: 30px;
        padding: 30px;
        background:
            linear-gradient(180deg, rgba(255,255,255,.055), rgba(255,255,255,.018));
        box-shadow: 0 26px 80px rgba(0,0,0,.32);
    }

    .additional-box h2 {
        margin: 0 0 10px;
        color: var(--gold-light);
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 34px;
    }

    .additional-box p {
        margin: 0 0 22px;
        color: var(--muted);
        line-height: 1.7;
    }

    .add-service-list {
        display: grid;
        gap: 14px;
    }

    .addon-item {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 12px;
        padding: 17px;
        border: 1px solid rgba(215,181,109,.22);
        border-radius: 18px;
        background: rgba(0,0,0,.24);
        cursor: pointer;
    }

    .addon-item input {
        width: 18px;
        height: 18px;
        margin-top: 3px;
    }

    .addon-item strong {
        display: flex;
        justify-content: space-between;
        gap: 14px;
        color: #fff;
        margin-bottom: 6px;
    }

    .addon-item strong span {
        color: var(--gold-light);
        white-space: nowrap;
    }

    .addon-item small {
        color: var(--muted);
        line-height: 1.5;
        display: block;
    }

    .cart-summary {
        margin-top: 24px;
        border-top: 1px solid rgba(255,255,255,.10);
        padding-top: 20px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        color: var(--muted);
        margin-bottom: 12px;
    }

    .summary-row strong {
        color: var(--gold-light);
    }

    .note-box {
        margin-top: 18px;
        color: rgba(255,255,255,.55);
        font-size: 13px;
        line-height: 1.7;
    }

    @media(max-width: 900px) {
        .order-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

<section class="order-page">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <a href="{{ route('services.index') }}">Services</a>
            <span>/</span>
            <a href="{{ route('services.show', $category->slug) }}">{{ $category->title }}</a>
            <span>/</span>
            <span>{{ $item->title }}</span>
        </div>

        <div class="order-grid">
            <div class="order-card">
                <div class="premium-badge">{{ $category->title }}</div>

                <h1>{{ $item->title }}</h1>

                <p>
                    {{ $item->short_description ?: 'Submit sample details for COAVerify™ review and batch verification workflow.' }}
                </p>

                <div class="price-box">
                    <span>Base Service Price</span>
                    <strong>{{ $item->currency ?: 'USD' }} {{ number_format((float) $item->base_price, 2) }}</strong>
                </div>

                <div class="params">
                    <div class="param-row">
                        <span>Category</span>
                        <strong>{{ $category->title }}</strong>
                    </div>

                    <div class="param-row">
                        <span>Turnaround Time</span>
                        <strong>{{ $item->turnaround_time ?: 'Standard review time' }}</strong>
                    </div>

                    <div class="param-row">
                        <span>Sample Requirement</span>
                        <strong>{{ $item->sample_requirement ?: 'Submit product label and sample details' }}</strong>
                    </div>

                    <div class="param-row">
                        <span>Result Format</span>
                        <strong>COAVerify™ Purity Report</strong>
                    </div>
                </div>

                <div class="note-box">
                    COAVerify™ facilitates independent third-party analytical verification through partner laboratory networks.
                </div>
            </div>

            <div class="additional-box">
                <h2>Additional Services</h2>

                <p>
                    Select optional add-on services for this sample review.
                    Selected add-ons will be added to your cart with the main service.
                </p>

                <form method="POST" action="{{ route('cart.add', $item) }}">
                    @csrf

                    <div class="add-service-list">
                        @forelse($additionalServices as $service)
                            <label class="addon-item">
                                <input
                                    type="checkbox"
                                    name="additional_services[]"
                                    value="{{ $service->id }}"
                                >

                                <span>
                                    <strong>
                                        {{ $service->title }}
                                        <span>+{{ $service->currency }} {{ number_format((float) $service->price, 2) }}</span>
                                    </strong>

                                    <small>
                                        {{ $service->description ?: 'Optional add-on service for the selected sample review.' }}
                                    </small>
                                </span>
                            </label>
                        @empty
                            <div style="color:var(--muted);line-height:1.7;">
                                No additional services available right now.
                            </div>
                        @endforelse
                    </div>

                    <div class="cart-summary">
                        <div class="summary-row">
                            <span>Base Price</span>
                            <strong>{{ $item->currency ?: 'USD' }} {{ number_format((float) $item->base_price, 2) }}</strong>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width:100%;margin-top:12px;">
                            Add to Cart
                        </button>

                        <a href="{{ route('services.show', $category->slug) }}" class="btn btn-outline" style="width:100%;margin-top:12px;">
                            Back to Category
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection