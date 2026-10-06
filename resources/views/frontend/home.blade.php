@extends('frontend.layouts.app')

@php
    $siteSetting = \App\Models\SiteSetting::current();

    $popularItems = collect($popularItems ?? []);
    $categories = collect($categories ?? []);

    $heroBadge = $siteSetting->home_hero_badge ?: 'Third-Party Batch Verification';
    $heroTitle = $siteSetting->home_hero_title ?: 'Independent COA Verification';
    $heroHighlight = $siteSetting->home_hero_highlight ?: 'You Can Trust';

    $heroDescription = $siteSetting->home_hero_description ?: 'COAVerify™ delivers clean, secure, purity-focused verification reports with instant batch authentication. Clients submit samples, we manage the verification workflow, and buyers can verify batch results online.';

    $primaryButtonText = $siteSetting->home_primary_button_text ?: 'Verify a Batch';
    $secondaryButtonText = $siteSetting->home_secondary_button_text ?: 'Test Your Sample';
    $thirdButtonText = $siteSetting->home_third_button_text ?: 'Submit Sample';

    $heroImage = $siteSetting->home_hero_image
        ? asset('storage/' . $siteSetting->home_hero_image)
        : asset('storage/home/hero-report.png');

    $howImage = $siteSetting->home_how_image
        ? asset('storage/' . $siteSetting->home_how_image)
        : asset('storage/home/how-it-works.png');

    $labImage = $siteSetting->home_lab_image
        ? asset('storage/' . $siteSetting->home_lab_image)
        : asset('storage/home/lab-testing.png');

    $howTitle = $siteSetting->home_how_title ?: 'How COAVerify™ Works';

    $howDescription = $siteSetting->home_how_description ?: 'A clean three-step verification journey designed for clients and buyers who need clear batch authenticity, simple reporting, and fast online verification.';

    $labTitle = $siteSetting->home_lab_title ?: 'Built for Laboratory-Level Confidence';

    $labDescription = $siteSetting->home_lab_description ?: 'COAVerify™ gives clients and end users a premium, trustworthy experience with clean purity verification and secure batch authentication.';

    $verifiedCount = $verifiedReportsCount ?? 0;
@endphp

@section('title', ($siteSetting->site_name ?: 'COAVerify™') . ' - Independent COA Verification You Can Trust')
@section('meta_description', 'COAVerify™ provides independent third-party peptide purity verification, secure batch authentication, and clean COA verification reports.')

@push('styles')
<style>
    .home-page {
        overflow: hidden;
    }

    .hero {
        position: relative;
        padding: 92px 0 76px;
        background:
            radial-gradient(circle at 18% 10%, rgba(247,220,149,.16), transparent 30%),
            radial-gradient(circle at 88% 22%, rgba(215,181,109,.11), transparent 28%),
            linear-gradient(180deg, rgba(255,255,255,.035), transparent 78%);
    }

    .hero:before {
        content: "";
        position: absolute;
        inset: 0;
        background:
            linear-gradient(90deg, rgba(215,181,109,.04) 1px, transparent 1px),
            linear-gradient(rgba(215,181,109,.035) 1px, transparent 1px);
        background-size: 76px 76px;
        opacity: .28;
        pointer-events: none;
    }

    .hero:after {
        content: "";
        position: absolute;
        left: 50%;
        bottom: -130px;
        transform: translateX(-50%);
        width: 900px;
        height: 260px;
        background: radial-gradient(circle, rgba(215,181,109,.13), transparent 65%);
        pointer-events: none;
    }

    .hero-grid {
        position: relative;
        z-index: 2;
        display: grid;
        grid-template-columns: 1.04fr .96fr;
        gap: 52px;
        align-items: center;
    }

    .hero-kicker {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: var(--gold-light);
        border: 1px solid rgba(215,181,109,.36);
        background: rgba(215,181,109,.08);
        border-radius: 999px;
        padding: 9px 15px;
        font-size: 12px;
        font-weight: 900;
        letter-spacing: .9px;
        text-transform: uppercase;
        margin-bottom: 22px;
    }

    .hero-kicker:before {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--gold-light);
        box-shadow: 0 0 18px rgba(247,220,149,.72);
    }

    .hero h1 {
        margin: 0 0 22px;
        color: #fff;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(44px, 6vw, 80px);
        line-height: .97;
        letter-spacing: -1.4px;
    }

    .hero h1 span {
        color: var(--gold-light);
    }

    .hero p {
        max-width: 690px;
        margin: 0 0 30px;
        color: rgba(255,255,255,.70);
        font-size: 18px;
        line-height: 1.8;
    }

    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        align-items: center;
        margin-bottom: 34px;
    }

    .hero-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        max-width: 650px;
    }

    .hero-stat {
        border: 1px solid rgba(215,181,109,.22);
        border-radius: 20px;
        padding: 17px;
        background:
            linear-gradient(180deg, rgba(255,255,255,.05), rgba(255,255,255,.018));
        box-shadow: 0 15px 40px rgba(0,0,0,.20);
    }

    .hero-stat strong {
        display: block;
        color: var(--gold-light);
        font-size: 27px;
        margin-bottom: 5px;
    }

    .hero-stat span {
        color: rgba(255,255,255,.62);
        font-size: 13px;
        line-height: 1.5;
    }

    .hero-visual {
        position: relative;
    }

    .hero-report-image-card {
        position: relative;
        max-width: 520px;
        margin-left: auto;
        border: 1px solid rgba(215,181,109,.40);
        border-radius: 34px;
        padding: 18px;
        background:
            radial-gradient(circle at top, rgba(215,181,109,.14), transparent 42%),
            linear-gradient(180deg, rgba(255,255,255,.065), rgba(255,255,255,.018)),
            #0b0b0b;
        box-shadow: 0 35px 90px rgba(0,0,0,.45);
        overflow: hidden;
    }

    .hero-report-image-card:before {
        content: "";
        position: absolute;
        inset: 16px;
        border: 1px solid rgba(215,181,109,.17);
        border-radius: 24px;
        pointer-events: none;
        z-index: 2;
    }

    .hero-report-image-card:after {
        content: "";
        position: absolute;
        top: -70px;
        left: 90px;
        width: 360px;
        height: 150px;
        border-radius: 50%;
        background: rgba(247,220,149,.14);
        filter: blur(10px);
        pointer-events: none;
    }

    .hero-report-frame {
        position: relative;
        z-index: 3;
        border-radius: 26px;
        background: #050505;
        border: 1px solid rgba(215,181,109,.26);
        overflow: hidden;
        padding: 10px;
    }

    .hero-report-img {
        width: 100%;
        height: auto;
        max-height: 540px;
        object-fit: cover;
        display: block;
        border-radius: 18px;
        background: #000;
    }

    .hero-report-badge {
        position: absolute;
        left: 28px;
        top: 28px;
        z-index: 4;
        color: #86efac;
        background: rgba(34,197,94,.14);
        border: 1px solid rgba(34,197,94,.32);
        border-radius: 999px;
        padding: 9px 14px;
        font-size: 12px;
        font-weight: 900;
        box-shadow: 0 10px 25px rgba(0,0,0,.28);
    }

    .hero-report-floating {
        position: absolute;
        right: 10px;
        bottom: 34px;
        z-index: 4;
        border: 1px solid rgba(215,181,109,.34);
        background: rgba(8,8,8,.92);
        border-radius: 18px;
        padding: 15px 17px;
        color: #fff;
        box-shadow: 0 20px 50px rgba(0,0,0,.45);
    }

    .hero-report-floating strong {
        display: block;
        color: var(--gold-light);
        font-size: 21px;
        margin-bottom: 4px;
    }

    .section {
        padding: 78px 0;
    }

    .section-head {
        text-align: center;
        max-width: 820px;
        margin: 0 auto 42px;
    }

    .section-head .eyebrow,
    .works-content .eyebrow,
    .lab-copy .eyebrow {
        color: var(--gold-light);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-size: 12px;
        font-weight: 900;
        margin-bottom: 12px;
    }

    .section-head h2,
    .works-content h2,
    .lab-copy h2 {
        margin: 0 0 16px;
        color: #fff;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(34px, 5vw, 56px);
        line-height: 1.06;
    }

    .section-head p,
    .works-content p,
    .lab-copy p {
        margin: 0 auto;
        color: rgba(255,255,255,.68);
        font-size: 17px;
        line-height: 1.8;
    }

    .popular-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .popular-card {
        border: 1px solid rgba(215,181,109,.27);
        border-radius: 28px;
        overflow: hidden;
        background:
            radial-gradient(circle at top, rgba(215,181,109,.10), transparent 52%),
            linear-gradient(180deg, rgba(255,255,255,.052), rgba(255,255,255,.014)),
            #0b0b0b;
        box-shadow: 0 20px 55px rgba(0,0,0,.26);
        display: flex;
        flex-direction: column;
        min-height: 385px;
        transition: .24s ease;
    }

    .popular-card:hover {
        transform: translateY(-5px);
        border-color: rgba(215,181,109,.46);
        box-shadow: 0 30px 70px rgba(0,0,0,.36);
    }

    .popular-image {
        height: 172px;
        background:
            radial-gradient(circle at center, rgba(215,181,109,.15), transparent 62%),
            #080808;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px;
        border-bottom: 1px solid rgba(215,181,109,.17);
    }

    .popular-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
        border-radius: 16px;
    }

    .popular-placeholder {
        width: 100%;
        height: 100%;
        border: 1px solid rgba(215,181,109,.18);
        border-radius: 16px;
        display: grid;
        place-items: center;
        color: var(--gold-light);
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 40px;
        letter-spacing: 2px;
    }

    .popular-body {
        padding: 22px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .popular-category {
        color: var(--gold-light);
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .8px;
        font-weight: 900;
        margin-bottom: 12px;
    }

    .popular-body h3 {
        margin: 0 0 12px;
        color: #fff;
        font-size: 21px;
        line-height: 1.25;
    }

    .popular-body p {
        margin: 0 0 20px;
        color: rgba(255,255,255,.64);
        font-size: 14px;
        line-height: 1.6;
    }

    .popular-bottom {
        margin-top: auto;
        border-top: 1px solid rgba(255,255,255,.08);
        padding-top: 16px;
    }

    .popular-price {
        display: block;
        color: var(--gold-light);
        font-size: 24px;
        font-weight: 900;
        margin-bottom: 13px;
    }

    .works-section {
        background:
            radial-gradient(circle at top left, rgba(215,181,109,.105), transparent 32%),
            linear-gradient(180deg, rgba(255,255,255,.02), rgba(255,255,255,.01));
        border-top: 1px solid rgba(215,181,109,.14);
        border-bottom: 1px solid rgba(215,181,109,.14);
    }

    .works-grid {
        display: grid;
        grid-template-columns: .96fr 1.04fr;
        gap: 38px;
        align-items: center;
    }

    .works-image-card,
    .lab-image-card {
        position: relative;
        border: 1px solid rgba(215,181,109,.30);
        border-radius: 30px;
        padding: 16px;
        background:
            radial-gradient(circle at top, rgba(215,181,109,.13), transparent 42%),
            linear-gradient(180deg, rgba(255,255,255,.052), rgba(255,255,255,.014)),
            #0b0b0b;
        box-shadow: 0 30px 70px rgba(0,0,0,.34);
        overflow: hidden;
    }

    .works-image-card:before,
    .lab-image-card:before {
        content: "";
        position: absolute;
        inset: 14px;
        border: 1px solid rgba(215,181,109,.13);
        border-radius: 22px;
        pointer-events: none;
        z-index: 2;
    }

    .works-image-card img,
    .lab-image-card img {
        width: 100%;
        height: 430px;
        object-fit: contain;
        object-position: center;
        border-radius: 22px;
        display: block;
        background: #050505;
    }

    .works-content p {
        margin-bottom: 24px;
    }

    .steps-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
    }

    .step-card {
        border: 1px solid rgba(215,181,109,.24);
        border-radius: 22px;
        padding: 21px 22px;
        background:
            radial-gradient(circle at right, rgba(215,181,109,.065), transparent 40%),
            rgba(10,10,10,.78);
        position: relative;
        overflow: hidden;
    }

    .step-number {
        color: var(--gold-light);
        font-size: 34px;
        font-family: Georgia, 'Times New Roman', serif;
        margin-bottom: 9px;
    }

    .step-card h3 {
        margin: 0 0 8px;
        color: #fff;
        font-size: 22px;
    }

    .step-card p {
        margin: 0;
        color: rgba(255,255,255,.64);
        line-height: 1.65;
        font-size: 15px;
    }

    .lab-highlight-grid {
        display: grid;
        grid-template-columns: 1.02fr .98fr;
        gap: 38px;
        align-items: center;
    }

    .lab-copy p {
        margin: 0 0 18px;
    }

    .lab-points {
        display: grid;
        grid-template-columns: 1fr;
        gap: 14px;
        margin-top: 24px;
    }

    .lab-point {
        border: 1px solid rgba(215,181,109,.22);
        border-radius: 18px;
        padding: 16px 18px;
        background: rgba(255,255,255,.022);
    }

    .lab-point strong {
        display: block;
        color: var(--gold-light);
        margin-bottom: 6px;
        font-size: 17px;
    }

    .lab-point span {
        color: rgba(255,255,255,.64);
        font-size: 14px;
        line-height: 1.6;
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }

    .category-card {
        border: 1px solid rgba(215,181,109,.25);
        border-radius: 24px;
        padding: 24px;
        background:
            linear-gradient(180deg, rgba(255,255,255,.048), rgba(255,255,255,.014)),
            #0b0b0b;
        min-height: 170px;
        display: flex;
        flex-direction: column;
        transition: .24s ease;
    }

    .category-card:hover {
        transform: translateY(-3px);
        border-color: rgba(215,181,109,.48);
    }

    .category-card span {
        width: fit-content;
        color: var(--gold-light);
        background: rgba(215,181,109,.08);
        border: 1px solid rgba(215,181,109,.24);
        border-radius: 999px;
        padding: 7px 10px;
        font-size: 11px;
        font-weight: 900;
        margin-bottom: 16px;
    }

    .category-card h3 {
        margin: 0 0 10px;
        color: #fff;
        font-size: 22px;
    }

    .category-card p {
        margin: 0 0 18px;
        color: rgba(255,255,255,.64);
        font-size: 14px;
        line-height: 1.55;
    }

    .category-card a {
        margin-top: auto;
        color: var(--gold-light);
        font-weight: 900;
        font-size: 14px;
    }

    .verify-band {
        border: 1px solid rgba(215,181,109,.34);
        border-radius: 34px;
        padding: 38px;
        background:
            radial-gradient(circle at right, rgba(215,181,109,.16), transparent 36%),
            linear-gradient(180deg, rgba(255,255,255,.052), rgba(255,255,255,.016)),
            #0b0b0b;
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 26px;
        align-items: center;
        box-shadow: 0 30px 80px rgba(0,0,0,.32);
    }

    .verify-band h2 {
        margin: 0 0 10px;
        color: #fff;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: 42px;
    }

    .verify-band p {
        margin: 0;
        color: rgba(255,255,255,.66);
        line-height: 1.7;
        font-size: 16px;
    }

    .trust-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
    }

    .trust-card {
        border: 1px solid rgba(215,181,109,.24);
        border-radius: 24px;
        padding: 24px;
        background: rgba(255,255,255,.023);
        text-align: center;
    }

    .trust-icon {
        width: 58px;
        height: 58px;
        border-radius: 18px;
        display: grid;
        place-items: center;
        margin: 0 auto 16px;
        border: 1px solid rgba(215,181,109,.32);
        color: var(--gold-light);
        font-size: 25px;
        background: rgba(215,181,109,.07);
    }

    .trust-card h3 {
        margin: 0 0 10px;
        color: #fff;
        font-size: 20px;
    }

    .trust-card p {
        margin: 0;
        color: rgba(255,255,255,.64);
        line-height: 1.6;
        font-size: 14px;
    }

    @media(max-width: 1100px) {
        .hero-grid,
        .works-grid,
        .lab-highlight-grid,
        .verify-band {
            grid-template-columns: 1fr;
        }

        .hero-report-image-card {
            max-width: 620px;
            margin: 0 auto;
        }

        .popular-grid,
        .category-grid,
        .trust-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .works-image-card img,
        .lab-image-card img {
            height: 390px;
            object-fit: contain;
        }
    }

    @media(max-width: 700px) {
        .hero {
            padding: 62px 0 56px;
        }

        .hero-stats,
        .popular-grid,
        .category-grid,
        .trust-grid {
            grid-template-columns: 1fr;
        }

        .section {
            padding: 56px 0;
        }

        .hero-report-img {
            max-height: 420px;
        }

        .works-image-card img,
        .lab-image-card img {
            height: 280px;
            object-fit: contain;
        }

        .hero-report-floating {
            right: 12px;
            bottom: 24px;
        }

        .verify-band {
            padding: 28px;
        }

        .verify-band h2 {
            font-size: 34px;
        }
    }
</style>
@endpush

@section('content')

<main class="home-page">

    <section class="hero">
        <div class="container">
            <div class="hero-grid">
                <div>
                    <div class="hero-kicker">{{ $heroBadge }}</div>

                    <h1>
                        {{ $heroTitle }} <span>{{ $heroHighlight }}</span>
                    </h1>

                    <p>
                        {{ $heroDescription }}
                    </p>

                    <div class="hero-actions">
                        <a href="{{ route('verify.index') }}" class="btn btn-primary">{{ $primaryButtonText }}</a>
                        <a href="{{ route('services.index') }}" class="btn btn-outline">{{ $secondaryButtonText }}</a>
                        <a href="{{ route('sample.submit') }}" class="btn btn-outline">{{ $thirdButtonText }}</a>
                    </div>

                    <div class="hero-stats">
                        <div class="hero-stat">
                            <strong>{{ $verifiedCount ?: '100+' }}</strong>
                            <span>Verified batch records</span>
                        </div>

                        <div class="hero-stat">
                            <strong>99%</strong>
                            <span>Purity-focused reports</span>
                        </div>

                        <div class="hero-stat">
                            <strong>24/7</strong>
                            <span>Public batch lookup</span>
                        </div>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="hero-report-image-card">
                        <div class="hero-report-badge">Verified Report Preview</div>

                        <div class="hero-report-frame">
                            <img
                                src="{{ $heroImage }}"
                                alt="COAVerify Report Preview"
                                class="hero-report-img"
                            >
                        </div>

                        <div class="hero-report-floating">
                            <strong>Instant</strong>
                            Batch Lookup
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-head">
                <div class="eyebrow">Most Popular Verification Services</div>
                <h2>Choose a Purity Verification Service</h2>
                <p>
                    Select a service, add optional review extras, and submit your sample details through a simple workflow.
                </p>
            </div>

            <div class="popular-grid">
                @forelse($popularItems as $item)
                    <article class="popular-card">
                        <div class="popular-image">
                            @if($item->thumbnail)
                                <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}">
                            @else
                                <div class="popular-placeholder">COA</div>
                            @endif
                        </div>

                        <div class="popular-body">
                            <div class="popular-category">
                                {{ $item->category?->title ?? 'Verification' }}
                            </div>

                            <h3>{{ $item->title }}</h3>

                            <p>
                                {{ $item->short_description ?: 'Submit sample details for COAVerify™ purity-focused verification workflow.' }}
                            </p>

                            <div class="popular-bottom">
                                <span class="popular-price">
                                    {{ $item->currency ?: 'USD' }} {{ number_format((float) $item->base_price, 2) }}
                                </span>

                                @if($item->category?->slug)
                                    <a href="{{ route('services.item', [$item->category->slug, $item->slug]) }}" class="btn btn-primary">
                                        {{ $item->price_label ?: 'Order Now' }}
                                    </a>
                                @else
                                    <a href="{{ route('services.index') }}" class="btn btn-primary">View Services</a>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    @foreach(['Peptide Purity Verification', 'Batch Authentication Report', 'Custom Sample Review', 'Third-Party Verification'] as $demo)
                        <article class="popular-card">
                            <div class="popular-image">
                                <div class="popular-placeholder">COA</div>
                            </div>

                            <div class="popular-body">
                                <div class="popular-category">Verification</div>
                                <h3>{{ $demo }}</h3>
                                <p>Admin se service items add karne ke baad yahan dynamic services show hongi.</p>

                                <div class="popular-bottom">
                                    <span class="popular-price">USD 300.00</span>
                                    <a href="{{ route('services.index') }}" class="btn btn-primary">View Services</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    <section class="section works-section">
        <div class="container">
            <div class="works-grid">
                <div class="works-image-card">
                    <img src="{{ $howImage }}" alt="{{ $howTitle }}">
                </div>

                <div class="works-content">
                    <div class="eyebrow">Simple Workflow</div>
                    <h2>{{ $howTitle }}</h2>

                    <p>
                        {{ $howDescription }}
                    </p>

                    <div class="steps-grid">
                        <div class="step-card">
                            <div class="step-number">01</div>
                            <h3>Submit Sample</h3>
                            <p>Client submits company, product, batch, notes, and supporting file through the sample form.</p>
                        </div>

                        <div class="step-card">
                            <div class="step-number">02</div>
                            <h3>Verification Process</h3>
                            <p>The sample record is reviewed through our backend workflow and prepared for purity verification.</p>
                        </div>

                        <div class="step-card">
                            <div class="step-number">03</div>
                            <h3>Report Issued</h3>
                            <p>A clean COAVerify™ report is issued and buyers can verify the batch number instantly online.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="lab-highlight-grid">
                <div class="lab-copy">
                    <div class="eyebrow">Professional Verification Environment</div>
                    <h2>{{ $labTitle }}</h2>

                    <p>
                        {{ $labDescription }}
                    </p>

                    <p>
                        The platform keeps everything simple and focused — product, purity percentage, company name,
                        batch number, verified status, and downloadable branded report.
                    </p>

                    <div class="lab-points">
                        <div class="lab-point">
                            <strong>Clean Purity Reporting</strong>
                            <span>No unnecessary clutter, no confusing chemistry data, only the key verification result.</span>
                        </div>

                        <div class="lab-point">
                            <strong>Secure Batch Authentication</strong>
                            <span>Exact-match verification allows end users to confirm report authenticity instantly.</span>
                        </div>

                        <div class="lab-point">
                            <strong>Professional Presentation</strong>
                            <span>Premium black and gold design makes the platform feel authoritative and trustworthy.</span>
                        </div>
                    </div>
                </div>

                <div class="lab-image-card">
                    <img src="{{ $labImage }}" alt="{{ $labTitle }}">
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-head">
                <div class="eyebrow">Sample Categories</div>
                <h2>What We Verify</h2>
                <p>
                    Focused categories with simple purity verification language. No clutter, no confusing data.
                </p>
            </div>

            <div class="category-grid">
                @forelse($categories as $category)
                    <article class="category-card">
                        <span>{{ $category->badge ?: 'Category' }}</span>

                        <h3>{{ $category->title }}</h3>

                        <p>{{ $category->subtitle ?: 'Purity-focused sample verification category.' }}</p>

                        <a href="{{ route('services.show', $category->slug) }}">
                            Explore {{ $category->active_items_count ?? 0 }} Options →
                        </a>
                    </article>
                @empty
                    <article class="category-card">
                        <span>Popular</span>
                        <h3>Peptides</h3>
                        <p>Purity verification for research peptide samples.</p>
                        <a href="{{ route('services.index') }}">Explore Services →</a>
                    </article>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section" style="padding-top:20px;">
        <div class="container">
            <div class="verify-band">
                <div>
                    <h2>Verify a Batch Instantly</h2>

                    <p>
                        Buyers can enter a batch number and instantly confirm product name, purity percentage,
                        company name, verification date, and verified status.
                    </p>
                </div>

                <a href="{{ route('verify.index') }}" class="btn btn-primary">
                    Verify a Batch
                </a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section-head">
                <div class="eyebrow">Trust & Security</div>
                <h2>Built for Confidence</h2>
                <p>
                    The platform is designed to feel premium, simple, and authoritative for both clients and end users.
                </p>
            </div>

            <div class="trust-grid">
                <div class="trust-card">
                    <div class="trust-icon">✓</div>
                    <h3>Verified Status</h3>
                    <p>Each public record clearly displays verified status and batch details.</p>
                </div>

                <div class="trust-card">
                    <div class="trust-icon">#</div>
                    <h3>Batch Lookup</h3>
                    <p>Exact match batch authentication keeps verification simple and fast.</p>
                </div>

                <div class="trust-card">
                    <div class="trust-icon">%</div>
                    <h3>Purity Focused</h3>
                    <p>Reports stay clean and focused on the key purity verification result.</p>
                </div>

                <div class="trust-card">
                    <div class="trust-icon">PDF</div>
                    <h3>Branded Report</h3>
                    <p>Professional COAVerify™ report download for verified batch records.</p>
                </div>
            </div>
        </div>
    </section>

</main>

@endsection