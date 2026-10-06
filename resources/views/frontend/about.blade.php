Set-Content -Path "resources/views/frontend/about.blade.php" -Encoding UTF8 -Value @'
@extends('frontend.layouts.app')

@section('title', 'About Our Pharmaceutical Company | PharmaCare')
@section('meta_description', 'Know about PharmaCare, our mission, vision, quality standards and pharmaceutical business values.')

@section('content')

<section class="page-hero">
    <div class="container">
        <h1>About Our Company</h1>
        <p>
            PharmaCare is a quality-focused pharmaceutical company committed to delivering reliable
            healthcare products with trust, responsibility and ethical business practices.
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:35px;align-items:start;">
            <div class="card">
                <h3>Who We Are</h3>
                <p>
                    We are a pharmaceutical company focused on quality healthcare products, customer satisfaction
                    and reliable service. Our work is driven by strict quality standards and a commitment to
                    better healthcare.
                </p>
            </div>

            <div class="card">
                <h3>Our Quality Approach</h3>
                <p>
                    Quality is at the center of our process. We focus on safe product handling,
                    standard documentation, ethical communication and consistent business support.
                </p>
            </div>

            <div class="card">
                <h3>Our Mission</h3>
                <p>
                    To provide reliable pharmaceutical products and healthcare solutions that support
                    better treatment, trust and long-term business relationships.
                </p>
            </div>

            <div class="card">
                <h3>Our Vision</h3>
                <p>
                    To become a trusted name in the pharmaceutical industry through quality products,
                    professional service and responsible healthcare contribution.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="section" style="padding-top:0;">
    <div class="container">
        <div class="section-title">
            <h2>Our Core Values</h2>
            <p>We believe in trust, quality, responsibility and long-term partnerships.</p>
        </div>

        <div class="card-grid">
            <div class="card">
                <h3>Quality</h3>
                <p>Every product and process is managed with a quality-first mindset.</p>
            </div>

            <div class="card">
                <h3>Trust</h3>
                <p>We build transparent and dependable relationships with our clients.</p>
            </div>

            <div class="card">
                <h3>Ethics</h3>
                <p>Our business approach is professional, responsible and healthcare-focused.</p>
            </div>
        </div>
    </div>
</section>

<style>
    @media(max-width: 900px) {
        .section .container > div {
            grid-template-columns: 1fr !important;
        }
    }
</style>

@endsection
'@