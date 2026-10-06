Set-Content -Path "resources/views/frontend/products.blade.php" -Encoding UTF8 -Value @'
@extends('frontend.layouts.app')

@section('title', 'Pharmaceutical Products | PharmaCare')
@section('meta_description', 'Explore pharmaceutical products including tablets, capsules, syrups, injections and healthcare products.')
@section('meta_keywords', 'pharma products, medicines, tablets, capsules, syrups, injections')

@section('content')

<section class="page-hero">
    <div class="container">
        <h1>Our Products</h1>
        <p>
            Explore our quality-focused pharmaceutical product range designed for healthcare and wellness needs.
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Product Range</h2>
            <p>
                This is a starter static product page. Next step me ye products admin panel se dynamic ho jayenge.
            </p>
        </div>

        <div class="product-grid">
            <div class="product-card">
                <div class="product-icon">💊</div>
                <h3>Tablet Range</h3>
                <p>Quality tablet formulations for different healthcare requirements.</p>
                <a href="{{ route('contact') }}">Enquire Now</a>
            </div>

            <div class="product-card">
                <div class="product-icon">🧬</div>
                <h3>Capsule Range</h3>
                <p>Reliable capsule products manufactured with standard quality practices.</p>
                <a href="{{ route('contact') }}">Enquire Now</a>
            </div>

            <div class="product-card">
                <div class="product-icon">🧪</div>
                <h3>Syrup Range</h3>
                <p>Healthcare syrup products with safe and effective formulations.</p>
                <a href="{{ route('contact') }}">Enquire Now</a>
            </div>

            <div class="product-card">
                <div class="product-icon">🩺</div>
                <h3>Injection Range</h3>
                <p>Professional pharmaceutical product range for clinical needs.</p>
                <a href="{{ route('contact') }}">Enquire Now</a>
            </div>

            <div class="product-card">
                <div class="product-icon">🌿</div>
                <h3>Healthcare Products</h3>
                <p>General healthcare and wellness-focused pharmaceutical products.</p>
                <a href="{{ route('contact') }}">Enquire Now</a>
            </div>

            <div class="product-card">
                <div class="product-icon">🧴</div>
                <h3>Ointment Range</h3>
                <p>Topical healthcare products for various external care requirements.</p>
                <a href="{{ route('contact') }}">Enquire Now</a>
            </div>
        </div>
    </div>
</section>

<style>
    .product-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    .product-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 30px;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
        transition: .25s ease;
    }

    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 26px 60px rgba(15, 23, 42, 0.12);
    }

    .product-icon {
        width: 62px;
        height: 62px;
        display: grid;
        place-items: center;
        border-radius: 18px;
        background: #ecfdf5;
        font-size: 32px;
        margin-bottom: 20px;
    }

    .product-card h3 {
        margin: 0 0 12px;
        color: #062f4f;
        font-size: 22px;
    }

    .product-card p {
        color: #475569;
        line-height: 1.7;
        margin: 0 0 20px;
    }

    .product-card a {
        color: #047857;
        font-weight: 900;
    }

    @media(max-width: 900px) {
        .product-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

@endsection
'@