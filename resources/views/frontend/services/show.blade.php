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

    .tests-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .test-card {
        background:
            radial-gradient(circle at top right, rgba(215,181,109,.08), transparent 36%),
            linear-gradient(180deg, rgba(255,255,255,.055), rgba(255,255,255,.018));
        border: 1px solid rgba(215,181,109,.30);
        border-radius: 26px;
        min-height: 410px;
        display: flex;
        flex-direction: column;
        box-shadow: 0 20px 55px rgba(0,0,0,.26);
        position: relative;
        overflow: hidden;
        transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
    }

    .test-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 30px 70px rgba(0,0,0,.38);
        border-color: rgba(215,181,109,.50);
    }

    .test-card:before {
        content: "";
        position: absolute;
        inset: 0 0 auto 0;
        height: 3px;
        background: linear-gradient(90deg, transparent, var(--gold-light), transparent);
        z-index: 2;
    }

    .test-image-wrap {
        height: 220px;
        width: 100%;
        background:
            radial-gradient(circle at top, rgba(215,181,109,.18), transparent 62%),
            linear-gradient(180deg, rgba(255,255,255,.035), rgba(255,255,255,.012)),
            #080808;
        overflow: hidden;
        border-bottom: 1px solid rgba(215,181,109,.18);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        position: relative;
    }

    .test-image-wrap:after {
        content: "";
        position: absolute;
        left: 16px;
        right: 16px;
        bottom: 12px;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(215,181,109,.42), transparent);
    }

    .test-image-action {
        width: 100%;
        height: 100%;
        padding: 0;
        border: 0;
        background: transparent;
        cursor: zoom-in;
        position: relative;
        z-index: 3;
    }

    .test-image-frame {
        width: 100%;
        height: 100%;
        border-radius: 18px;
        background:
            radial-gradient(circle at center, rgba(215,181,109,.08), transparent 60%),
            linear-gradient(180deg, rgba(255,255,255,.045), rgba(255,255,255,.015)),
            #050505;
        border: 1px solid rgba(215,181,109,.18);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px;
        overflow: hidden;
        box-shadow: inset 0 0 24px rgba(0,0,0,.35);
        position: relative;
    }

    .test-image-frame:before {
        content: "Click to Zoom";
        position: absolute;
        right: 10px;
        bottom: 10px;
        font-size: 11px;
        letter-spacing: .4px;
        color: #fff;
        background: rgba(0,0,0,.55);
        border: 1px solid rgba(215,181,109,.28);
        padding: 6px 10px;
        border-radius: 999px;
        opacity: 0;
        transition: opacity .25s ease;
        pointer-events: none;
    }

    .test-image-action:hover .test-image-frame:before {
        opacity: 1;
    }

    .test-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center center;
        display: block;
        transition: transform .3s ease, filter .3s ease;
    }

    .test-card:hover .test-image {
        transform: scale(1.035);
        filter: brightness(1.06);
    }

    .test-image-placeholder {
        width: 100%;
        height: 100%;
        border-radius: 18px;
        display: grid;
        place-items: center;
        color: var(--gold-light);
        font-size: 42px;
        font-family: Georgia, 'Times New Roman', serif;
        background:
            radial-gradient(circle at top, rgba(215,181,109,.18), transparent 55%),
            #080808;
        border: 1px solid rgba(215,181,109,.18);
        letter-spacing: 2px;
    }

    .test-content {
        padding: 22px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .test-category {
        color: var(--gold-light);
        font-size: 12px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: .8px;
        margin-bottom: 14px;
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
        padding-top: 18px;
        border-top: 1px solid rgba(255,255,255,.08);
    }

    .price {
        display: block;
        color: var(--gold-light);
        font-size: 24px;
        font-weight: 900;
        margin-bottom: 14px;
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

    /* Popup / Lightbox */
    .image-popup {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.88);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 30px 20px;
        z-index: 9999;
        backdrop-filter: blur(3px);
    }

    .image-popup.active {
        display: flex;
    }

    .image-popup-dialog {
        position: relative;
        width: auto;
        max-width: 95vw;
        max-height: 92vh;
        text-align: center;
    }

    .image-popup-close {
        position: absolute;
        top: -18px;
        right: -18px;
        width: 42px;
        height: 42px;
        border: 1px solid rgba(215,181,109,.40);
        border-radius: 50%;
        background: #111;
        color: #fff;
        font-size: 24px;
        line-height: 38px;
        cursor: pointer;
        box-shadow: 0 10px 25px rgba(0,0,0,.4);
        z-index: 2;
    }

    .image-popup-close:hover {
        background: #1a1a1a;
        color: var(--gold-light);
    }

    .image-popup-image {
        display: block;
        max-width: 90vw;
        max-height: 80vh;
        width: auto;
        height: auto;
        border-radius: 18px;
        background: #0a0a0a;
        border: 1px solid rgba(215,181,109,.30);
        padding: 10px;
        box-shadow: 0 30px 80px rgba(0,0,0,.6);
    }

    .image-popup-caption {
        margin-top: 14px;
        color: #e5e5e5;
        font-size: 15px;
        line-height: 1.6;
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

        .test-image-wrap {
            height: 230px;
        }

        .image-popup-close {
            top: -10px;
            right: -2px;
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

            <div style="color:var(--muted);font-size:14px;">
                Display:
                <span style="color:var(--gold-light);font-weight:900;">
                    Active Services with Pricing
                </span>
            </div>
        </div>

        <div class="tests-grid">
            @forelse($category->activeItems as $item)
                <article class="test-card">
                    <div class="test-image-wrap">
                        @if($item->thumbnail)
                            <button
                                type="button"
                                class="test-image-action js-image-popup-trigger"
                                data-image="{{ asset('storage/' . $item->thumbnail) }}"
                                data-title="{{ $item->title }}"
                            >
                                <div class="test-image-frame">
                                    <img
                                        src="{{ asset('storage/' . $item->thumbnail) }}"
                                        alt="{{ $item->title }}"
                                        class="test-image"
                                    >
                                </div>
                            </button>
                        @else
                            <div class="test-image-placeholder">
                                COA
                            </div>
                        @endif
                    </div>

                    <div class="test-content">
                        <div class="test-category">{{ $category->title }}</div>

                        <h3>{{ $item->title }}</h3>

                        <p>
                            {{ $item->short_description ?: 'Submit sample details for COAVerify™ review and batch verification workflow.' }}
                        </p>

                        <div class="price-row">
                            <span class="price">
                                {{ $item->currency ?: 'USD' }} {{ number_format((float) $item->base_price, 2) }}
                            </span>

                            <a
                                href="{{ route('services.item', [$category->slug, $item->slug]) }}"
                                class="btn btn-primary"
                            >
                                {{ $item->price_label ?: 'Order Now' }}
                            </a>
                        </div>
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

<!-- Image Popup -->
<div class="image-popup" id="imagePopup">
    <div class="image-popup-dialog">
        <button type="button" class="image-popup-close" id="imagePopupClose">&times;</button>

        <img src="" alt="" class="image-popup-image" id="imagePopupImage">

        <div class="image-popup-caption" id="imagePopupCaption"></div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const popup = document.getElementById('imagePopup');
        const popupImage = document.getElementById('imagePopupImage');
        const popupCaption = document.getElementById('imagePopupCaption');
        const popupClose = document.getElementById('imagePopupClose');
        const triggers = document.querySelectorAll('.js-image-popup-trigger');

        if (!popup || !popupImage || !popupCaption || !popupClose || !triggers.length) {
            return;
        }

        function openPopup(imageSrc, imageTitle) {
            popupImage.src = imageSrc;
            popupImage.alt = imageTitle || 'Zoomed Image';
            popupCaption.textContent = imageTitle || '';
            popup.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closePopup() {
            popup.classList.remove('active');
            popupImage.src = '';
            popupImage.alt = '';
            popupCaption.textContent = '';
            document.body.style.overflow = '';
        }

        triggers.forEach(function (trigger) {
            trigger.addEventListener('click', function () {
                const imageSrc = this.getAttribute('data-image');
                const imageTitle = this.getAttribute('data-title');

                if (imageSrc) {
                    openPopup(imageSrc, imageTitle);
                }
            });
        });

        popupClose.addEventListener('click', closePopup);

        popup.addEventListener('click', function (e) {
            if (e.target === popup) {
                closePopup();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && popup.classList.contains('active')) {
                closePopup();
            }
        });
    });
</script>
@endpush