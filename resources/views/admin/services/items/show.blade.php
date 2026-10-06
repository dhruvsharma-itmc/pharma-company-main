@extends('frontend.layouts.app')

@section('title', $category->meta_title ?: $category->title . ' - COAVerify™ Sample Verification')
@section('meta_description', $category->meta_description ?: $category->description)

@push('styles')
<style>
    .category-hero {
        padding: 72px 0 42px;
        border-bottom: 1px solid rgba(215,181,109,.18);
        background:
            radial-gradient(circle at top left, rgba(215,181,109,.14), transparent 34%),
            linear-gradient(180deg, rgba(255,255,255,.02), transparent);
    }

    .breadcrumb {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        color: rgba(255,255,255,.55);
        font-size: 14px;
        margin-bottom: 22px;
    }

    .breadcrumb a {
        color: var(--gold-light);
    }

    .category-title-wrap {
        display: grid;
        grid-template-columns: 1.1fr .9fr;
        gap: 28px;
        align-items: end;
    }

    .category-hero h1 {
        margin: 0 0 16px;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(42px, 6vw, 74px);
        line-height: 1;
    }

    .category-hero p {
        margin: 0;
        color: var(--muted);
        font-size: 18px;
        line-height: 1.8;
        max-width: 760px;
    }

    .category-summary {
        border: 1px solid rgba(215,181,109,.30);
        border-radius: 24px;
        padding: 24px;
        background: rgba(255,255,255,.035);
    }

    .category-summary strong {
        display: block;
        color: var(--gold-light);
        font-size: 20px;
        margin-bottom: 8px;
    }

    .category-summary span {
        display: block;
        color: var(--muted);
        line-height: 1.7;
    }

    .tests-section {
        padding: 55px 0 90px;
    }

    .toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .toolbar h2 {
        margin: 0;
        font-size: 26px;
        color: #fff;
    }

    .sort-box {
        color: var(--muted);
        font-size: 14px;
    }

    .sort-box span {
        color: var(--gold-light);
        font-weight: 900;
    }

    .tests-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .test-card {
        background:
            linear-gradient(180deg, rgba(255,255,255,.055), rgba(255,255,255,.018));
        border: 1px solid rgba(215,181,109,.30);
        border-radius: 26px;
        padding: 22px;
        min-height: 250px;
        display: flex;
        flex-direction: column;
        box-shadow: 0 20px 55px rgba(0,0,0,.26);
        position: relative;
        overflow: hidden;
    }

    .test-card:before {
        content: "";
        position: absolute;
        inset: 0 0 auto 0;
        height: 3px;
        background: linear-gradient(90deg, transparent, var(--gold-light), transparent);
    }

    .test-category {
        color: var(--gold-light);
        font-size: 12px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: .8px;
        margin-bottom: 18px;
    }

    .test-card h3 {
        margin: 0 0 14px;
        color: #fff;
        font-size: 21px;
        line-height: 1.25;
    }

    .test-card p {
        margin: 0 0 20px;
        color: var(--muted);
        line-height: 1.6;
        font-size: 14px;
    }

    .price-row {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding-top: 18px;
        border-top: 1px solid rgba(255,255,255,.08);
    }

    .price-row strong {
        color: var(--gold-light);
        font-size: 15px;
    }

    .mini-btn {
        padding: 10px 14px;
        border-radius: 999px;
        background: linear-gradient(135deg, var(--gold-light), #b88b42);
        color: #050505;
        font-weight: 900;
        font-size: 13px;
    }

    .category-cta {
        margin-top: 34px;
        border: 1px solid rgba(215,181,109,.32);
        border-radius: 28px;
        padding: 32px;
        background:
            radial-gradient(circle at top right, rgba(215,181,109,.14), transparent 34%),
            rgba(255,255,255,.035);
        display: flex;
        justify-content: space-between;
        gap: 24px;
        align-items: center;
    }

    .category-cta h2 {
        margin: 0 0 8px;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 34px;
    }

    .category-cta p {
        margin: 0;
        color: var(--muted);
        line-height: 1.7;
    }

    @media(max-width: 1100px) {
        .tests-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .category-title-wrap,
        .category-cta {
            grid-template-columns: 1fr;
            display: grid;
        }
    }

    @media(max-width: 700px) {
        .tests-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

<section class="category-hero">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <a href="{{ route('services.index') }}">Services</a>
            <span>/</span>
            <span>{{ $category->title }}</span>
        </div>

        <div class="category-title-wrap">
            <div>
                <div class="premium-badge">{{ $category->badge ?? 'Category' }}</div>

                <h1>{{ $category->title }}</h1>

                <p>{{ $category->description }}</p>
            </div>

            <div class="category-summary">
                <strong>COAVerify™ Focus</strong>
                <span>
                    Simple purity-focused verification, secure batch authentication,
                    and clean public result display.
                </span>
            </div>
        </div>
    </div>
</section>

<section class="tests-section">
    <div class="container">
        <div class="toolbar">
            <h2>Available Sample Review Options</h2>

            <div class="sort-box">
                Sort by: <span>Admin Order</span> &nbsp; | &nbsp; Display: <span>Active Options</span>
            </div>
        </div>

        <div class="tests-grid">
            @forelse($category->activeItems as $item)
                <article class="test-card">
                    <div class="test-category">{{ $category->title }}</div>

                    <h3>{{ $item->title }}</h3>

                    <p>
                        {{ $item->short_description ?: 'Submit sample details for COAVerify™ review and batch verification workflow.' }}
                    </p>

                    <div class="price-row">
                        <strong>{{ $item->price_label ?: 'Request Review' }}</strong>

                        <a
                            href="{{ route('sample.submit') }}?category={{ urlencode($category->title) }}&sample={{ urlencode($item->title) }}"
                            class="mini-btn"
                        >
                            Submit
                        </a>
                    </div>
                </article>
            @empty
                <div style="grid-column:1/-1;color:#b9b9b9;border:1px solid rgba(215,181,109,.28);padding:24px;border-radius:22px;">
                    No active sample review options available in this category yet.
                </div>
            @endforelse
        </div>

        <div class="category-cta">
            <div>
                <h2>Need a Custom Review?</h2>
                <p>
                    If your sample type is not listed, submit the product details and our team will review the request.
                </p>
            </div>

            <a href="{{ route('sample.submit') }}?category={{ urlencode($category->title) }}" class="btn btn-primary">
                Submit Sample
            </a>
        </div>
    </div>
</section>

@endsection