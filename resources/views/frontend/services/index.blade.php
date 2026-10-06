@extends('frontend.layouts.app')

@section('title', 'What We Verify - COAVerify™ Services')
@section('meta_description', 'Explore COAVerify™ sample verification categories including peptides, SARMs, SERMs, selected research samples, and custom sample review.')

@push('styles')
<style>
    .services-hero {
        padding: 80px 0 45px;
        text-align: center;
    }

    .services-hero h1 {
        margin: 0 0 18px;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(42px, 6vw, 76px);
        line-height: 1;
    }

    .services-hero h1 span {
        color: var(--gold-light);
    }

    .services-hero p {
        max-width: 820px;
        margin: 0 auto;
        color: var(--muted);
        font-size: 18px;
        line-height: 1.8;
    }

    .services-section {
        padding: 45px 0 90px;
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    .service-card {
        position: relative;
        min-height: 360px;
        background:
            radial-gradient(circle at top right, rgba(215,181,109,.12), transparent 36%),
            linear-gradient(180deg, rgba(255,255,255,.055), rgba(255,255,255,.018));
        border: 1px solid rgba(215,181,109,.34);
        border-radius: 30px;
        padding: 30px;
        box-shadow: 0 26px 80px rgba(0,0,0,.32);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .service-card:before {
        content: "";
        position: absolute;
        inset: 0 0 auto 0;
        height: 3px;
        background: linear-gradient(90deg, transparent, var(--gold-light), transparent);
    }

    .service-badge {
        width: fit-content;
        padding: 7px 12px;
        border-radius: 999px;
        color: var(--gold-light);
        background: rgba(215,181,109,.10);
        border: 1px solid rgba(215,181,109,.28);
        font-size: 12px;
        font-weight: 900;
        margin-bottom: 18px;
    }

    .service-card h2 {
        margin: 0 0 12px;
        color: #fff;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 30px;
        line-height: 1.1;
    }

    .service-card p {
        margin: 0 0 20px;
        color: var(--muted);
        line-height: 1.7;
    }

    .service-list {
        list-style: none;
        padding: 0;
        margin: 0 0 24px;
        display: grid;
        gap: 9px;
    }

    .service-list li {
        color: rgba(255,255,255,.78);
        font-size: 14px;
        line-height: 1.5;
    }

    .service-list li:before {
        content: "•";
        color: var(--gold-light);
        margin-right: 8px;
    }

    .service-actions {
        margin-top: auto;
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .services-note {
        margin-top: 35px;
        border: 1px solid rgba(215,181,109,.28);
        border-radius: 24px;
        padding: 26px;
        background: rgba(255,255,255,.035);
        color: var(--muted);
        line-height: 1.8;
        text-align: center;
    }

    @media(max-width: 1000px) {
        .services-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

<section class="services-hero">
    <div class="container">
        <div class="premium-badge">Sample Categories</div>

        <h1>What We <span>Verify</span></h1>

        <p>
            COAVerify™ is focused on simple, professional, purity-focused verification.
            Browse sample categories below and submit the relevant product details for review.
        </p>
    </div>
</section>

<section class="services-section">
    <div class="container">
        <div class="services-grid">
            @forelse($categories as $category)
                <article class="service-card">
                    <div class="service-badge">{{ $category->badge ?? 'Category' }}</div>

                    <h2>{{ $category->title }}</h2>

                    <p>{{ $category->subtitle }}</p>

                    <ul class="service-list">
                        @foreach($category->activeItems as $item)
                            <li>{{ $item->title }}</li>
                        @endforeach
                    </ul>

                    <div class="service-actions">
                        <a href="{{ route('services.show', $category->slug) }}" class="btn btn-primary">
                            Explore Category
                        </a>

                        <a href="{{ route('sample.submit') }}?category={{ urlencode($category->title) }}" class="btn btn-outline">
                            Submit Sample
                        </a>
                    </div>
                </article>
            @empty
                <div class="services-note" style="grid-column:1/-1;">
                    No active service categories available yet.
                </div>
            @endforelse
        </div>

        <div class="services-note">
            Didn’t find your sample category? Submit your product details through the sample submission form and our team will review the request.
        </div>
    </div>
</section>

@endsection