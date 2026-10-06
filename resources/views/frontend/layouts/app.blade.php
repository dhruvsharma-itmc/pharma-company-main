<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        $siteSetting = \App\Models\SiteSetting::current();
        $cartCount = count(session('cart.items', []));
    @endphp

    <title>@yield('title', ($siteSetting->site_name ?? 'COAVerify™') . ' - Independent COA Verification')</title>

    <meta name="description" content="@yield('meta_description', 'COAVerify™ provides independent third-party peptide purity verification, secure batch authentication, and clean COA verification reports.')">

    <meta name="keywords" content="@yield('meta_keywords', 'COA verification, peptide purity verification, batch verification, third-party verified COA, COAVerify')">

    <meta name="robots" content="index, follow">

    <link rel="canonical" href="{{ url()->current() }}">

    @if(!empty($siteSetting->favicon))
        <link rel="icon" href="{{ asset('storage/' . $siteSetting->favicon) }}">
    @endif

    <style>
        :root {
            --black: #050505;
            --black-soft: #0b0b0b;
            --gold: #d7b56d;
            --gold-light: #f7dc95;
            --gold-dark: #9d7637;
            --white: #ffffff;
            --muted: rgba(255,255,255,.68);
            --border: rgba(215,181,109,.28);
            --green: #86efac;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background:
                radial-gradient(circle at top left, rgba(215,181,109,.08), transparent 28%),
                var(--black);
            color: var(--white);
            font-family: Arial, Helvetica, sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        img {
            max-width: 100%;
        }

        .container {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
        }

        .site-header {
            position: sticky;
            top: 0;
            z-index: 999;
            background:
                linear-gradient(180deg, rgba(5,5,5,.98), rgba(5,5,5,.91));
            border-bottom: 1px solid rgba(215,181,109,.20);
            backdrop-filter: blur(14px);
        }

        .header-inner {
            min-height: 106px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 16px;
            min-width: 300px;
        }

        .brand-logo-img {
            width: 145px;
            max-height: 92px;
            object-fit: contain;
            display: block;
            flex: 0 0 auto;
        }

        .brand-logo-fallback {
            width: 92px;
            height: 92px;
            border-radius: 24px;
            display: grid;
            place-items: center;
            color: var(--gold-light);
            border: 1px solid rgba(215,181,109,.42);
            background: rgba(215,181,109,.08);
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 42px;
            font-weight: 900;
            box-shadow: 0 16px 36px rgba(0,0,0,.38);
            flex: 0 0 auto;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }

        .brand-text strong {
            color: #fff;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 20px;
            letter-spacing: .2px;
            white-space: nowrap;
        }

        .brand-text span {
            margin-top: 7px;
            color: var(--gold-light);
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .8px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .nav-wrap {
            display: flex;
            align-items: center;
            gap: 22px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 22px;
        }

        .nav-links a {
            color: rgba(255,255,255,.78);
            font-size: 14px;
            font-weight: 800;
            letter-spacing: .2px;
            transition: .2s ease;
            white-space: nowrap;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: var(--gold-light);
        }

        .nav-btn {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            padding: 12px 18px;
            border-radius: 999px;
            color: #080808 !important;
            background: linear-gradient(135deg, var(--gold-light), var(--gold));
            font-weight: 900;
            border: 1px solid rgba(255,255,255,.12);
            box-shadow: 0 12px 30px rgba(215,181,109,.16);
        }

        .nav-btn:hover {
            color: #080808 !important;
            transform: translateY(-1px);
        }

        .mobile-toggle {
            display: none;
            width: 46px;
            height: 46px;
            border-radius: 14px;
            border: 1px solid rgba(215,181,109,.28);
            background: rgba(255,255,255,.035);
            color: #fff;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .mobile-toggle span {
            position: relative;
            width: 22px;
            height: 2px;
            background: var(--gold-light);
            display: block;
        }

        .mobile-toggle span:before,
        .mobile-toggle span:after {
            content: "";
            position: absolute;
            left: 0;
            width: 22px;
            height: 2px;
            background: var(--gold-light);
            transition: .2s ease;
        }

        .mobile-toggle span:before {
            top: -7px;
        }

        .mobile-toggle span:after {
            top: 7px;
        }

        .mobile-toggle.active span {
            background: transparent;
        }

        .mobile-toggle.active span:before {
            top: 0;
            transform: rotate(45deg);
        }

        .mobile-toggle.active span:after {
            top: 0;
            transform: rotate(-45deg);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 999px;
            padding: 13px 20px;
            font-size: 14px;
            font-weight: 900;
            border: 1px solid transparent;
            cursor: pointer;
            transition: .22s ease;
        }

        .btn-primary {
            color: #080808;
            background: linear-gradient(135deg, var(--gold-light), var(--gold));
            box-shadow: 0 14px 34px rgba(215,181,109,.16);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
        }

        .btn-outline {
            color: var(--gold-light);
            border-color: rgba(215,181,109,.32);
            background: rgba(255,255,255,.025);
        }

        .btn-outline:hover {
            background: rgba(215,181,109,.08);
            transform: translateY(-2px);
        }

        .premium-badge {
            display: inline-flex;
            align-items: center;
            color: var(--gold-light);
            border: 1px solid rgba(215,181,109,.32);
            background: rgba(215,181,109,.08);
            border-radius: 999px;
            padding: 8px 13px;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .8px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        .site-footer {
            border-top: 1px solid rgba(215,181,109,.20);
            background:
                radial-gradient(circle at top, rgba(215,181,109,.08), transparent 42%),
                #030303;
            padding: 42px 0 28px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.1fr .9fr;
            gap: 28px;
            align-items: start;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 16px;
        }

        .footer-logo-img {
            width: 110px;
            max-height: 72px;
            object-fit: contain;
            display: block;
        }

        .footer-brand strong {
            display: block;
            color: #fff;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 26px;
        }

        .footer-brand span {
            display: block;
            margin-top: 4px;
            color: var(--gold-light);
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .7px;
        }

        .footer-text {
            color: rgba(255,255,255,.60);
            line-height: 1.7;
            max-width: 640px;
            margin: 0;
            font-size: 14px;
        }

        .footer-links {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 14px;
        }

        .footer-links a {
            color: rgba(255,255,255,.68);
            font-weight: 800;
            font-size: 14px;
        }

        .footer-links a:hover {
            color: var(--gold-light);
        }

        .footer-bottom {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,.08);
            color: rgba(255,255,255,.45);
            font-size: 13px;
            display: flex;
            justify-content: space-between;
            gap: 18px;
            flex-wrap: wrap;
        }

        @media(max-width: 1120px) {
            .header-inner {
                min-height: 92px;
            }

            .brand-logo {
                min-width: auto;
                gap: 13px;
            }

            .brand-logo-img {
                width: 118px;
                max-height: 78px;
            }

            .brand-logo-fallback {
                width: 78px;
                height: 78px;
                border-radius: 20px;
                font-size: 34px;
            }

            .brand-text strong {
                font-size: 25px;
            }

            .brand-text span {
                font-size: 12px;
            }

            .nav-links {
                gap: 15px;
            }

            .nav-links a {
                font-size: 13px;
            }
        }

        @media(max-width: 920px) {
            .header-inner {
                min-height: 82px;
            }

            .mobile-toggle {
                display: inline-flex;
            }

            .nav-wrap {
                position: absolute;
                top: 100%;
                left: 16px;
                right: 16px;
                display: none;
                border: 1px solid rgba(215,181,109,.24);
                border-radius: 22px;
                background: rgba(5,5,5,.98);
                box-shadow: 0 24px 70px rgba(0,0,0,.45);
                padding: 16px;
            }

            .nav-wrap.active {
                display: block;
            }

            .nav-links {
                flex-direction: column;
                align-items: stretch;
                gap: 0;
            }

            .nav-links a {
                padding: 14px 14px;
                border-bottom: 1px solid rgba(255,255,255,.08);
                font-size: 14px;
            }

            .nav-links a:last-child {
                border-bottom: 0;
            }

            .nav-btn {
                margin-top: 10px;
                width: 100%;
            }
        }

        @media(max-width: 640px) {
            .container {
                width: min(100% - 24px, 1180px);
            }

            .header-inner {
                min-height: 74px;
                gap: 12px;
            }

            .brand-logo {
                gap: 9px;
                min-width: auto;
            }

            .brand-logo-img {
                width: 82px;
                max-height: 56px;
            }

            .brand-logo-fallback {
                width: 58px;
                height: 58px;
                border-radius: 16px;
                font-size: 26px;
            }

            .brand-text strong {
                font-size: 19px;
                max-width: 155px;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .brand-text span {
                font-size: 10px;
                max-width: 155px;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .mobile-toggle {
                width: 42px;
                height: 42px;
                border-radius: 13px;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .footer-links {
                justify-content: flex-start;
            }

            .footer-logo-img {
                width: 86px;
                max-height: 58px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

<header class="site-header">
    <div class="container">
        <div class="header-inner">
            <a href="{{ route('home') }}" class="brand-logo" aria-label="COAVerify Home">
                @if(!empty($siteSetting->site_logo))
                    <img
                        src="{{ asset('storage/' . $siteSetting->site_logo) }}"
                        alt="{{ $siteSetting->site_name ?: 'COAVerify™' }}"
                        class="brand-logo-img"
                    >
                @else
                    <span class="brand-logo-fallback">✓</span>
                @endif

                <span class="brand-text">
                    <strong>{{ $siteSetting->site_name ?: 'COAVerify™' }}</strong>
                    <span>{{ $siteSetting->site_tagline ?: 'Batch Purity Verification' }}</span>
                </span>
            </a>

            <button type="button" class="mobile-toggle" id="mobileToggle" aria-label="Open Menu">
                <span></span>
            </button>

            <div class="nav-wrap" id="navWrap">
                <nav class="nav-links">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>

                    <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'active' : '' }}">Services</a>

                    <!--<a href="{{ route('verify.index') }}" class="{{ request()->routeIs('verify.*') ? 'active' : '' }}">Verify Batch</a>-->

                    <a href="{{ route('sample.submit') }}" class="{{ request()->routeIs('sample.*') ? 'active' : '' }}">Submit Sample</a>

 

                    <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.*') ? 'active' : '' }}">
                        Cart @if($cartCount > 0)({{ $cartCount }})@endif
                    </a>
                    
                                       <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.*') ? 'active' : '' }}">User Login</a>

                    <a href="{{ route('admin.login') }}">Admin Login</a>

                    <a href="{{ route('verify.index') }}" class="nav-btn">Verify a Batch</a>
                </nav>
            </div>
        </div>
    </div>
</header>

@yield('content')

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">
                    @if(!empty($siteSetting->site_logo))
                        <img
                            src="{{ asset('storage/' . $siteSetting->site_logo) }}"
                            alt="{{ $siteSetting->site_name ?: 'COAVerify™' }}"
                            class="footer-logo-img"
                        >
                    @endif

                    <div>
                        <strong>{{ $siteSetting->site_name ?: 'COAVerify™' }}</strong>
                        <span>{{ $siteSetting->site_tagline ?: 'Batch Purity Verification' }}</span>
                    </div>
                </div>

                <p class="footer-text">
                    {{ $siteSetting->footer_disclaimer ?: 'COAVerify™ facilitates independent third-party analytical verification through partner laboratory networks.' }}
                </p>
            </div>

            <div class="footer-links">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('services.index') }}">Services</a>
                <a href="{{ route('verify.index') }}">Verify</a>
                <a href="{{ route('sample.submit') }}">Submit Sample</a>

                @if(Route::has('contact'))
                    <a href="{{ route('contact') }}">Contact</a>
                @endif
            </div>
        </div>

        <div class="footer-bottom">
            <span>© {{ date('Y') }} {{ $siteSetting->site_name ?: 'COAVerify™' }}. All rights reserved.</span>
            <span>Secure Batch Authentication • Purity Verification Reports</span>
        </div>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mobileToggle = document.getElementById('mobileToggle');
        const navWrap = document.getElementById('navWrap');

        if (mobileToggle && navWrap) {
            mobileToggle.addEventListener('click', function () {
                mobileToggle.classList.toggle('active');
                navWrap.classList.toggle('active');
            });

            document.addEventListener('click', function (event) {
                const clickedInsideHeader = event.target.closest('.site-header');

                if (!clickedInsideHeader) {
                    mobileToggle.classList.remove('active');
                    navWrap.classList.remove('active');
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    mobileToggle.classList.remove('active');
                    navWrap.classList.remove('active');
                }
            });
        }
    });
</script>

@stack('scripts')

</body>
</html>
