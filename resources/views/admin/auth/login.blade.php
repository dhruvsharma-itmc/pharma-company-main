<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - COAVerify™</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        :root {
            --black: #050505;
            --gold: #d7b56d;
            --gold-light: #f7dc95;
            --muted: #b9b9b9;
            --border: rgba(215,181,109,.34);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background:
                radial-gradient(circle at top, rgba(215,181,109,.20), transparent 34%),
                linear-gradient(180deg, #090909, #000);
            color: #fff;
            font-family: Arial, Helvetica, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .login-wrapper {
            width: min(1080px, 100%);
            display: grid;
            grid-template-columns: 1fr 440px;
            gap: 28px;
            align-items: stretch;
        }

        .brand-panel {
            border: 1px solid var(--border);
            background:
                radial-gradient(circle at top left, rgba(215,181,109,.18), transparent 38%),
                rgba(255,255,255,.04);
            border-radius: 32px;
            padding: 48px;
            min-height: 560px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 28px 90px rgba(0,0,0,.45);
        }

        .brand-logo strong {
            display: block;
            font-family: Georgia, 'Times New Roman', serif;
            color: var(--gold-light);
            font-size: 44px;
            margin-bottom: 8px;
        }

        .brand-logo span {
            color: var(--muted);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-size: 12px;
        }

        .brand-panel h1 {
            margin: 50px 0 18px;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: clamp(38px, 5vw, 64px);
            line-height: 1;
        }

        .brand-panel p {
            margin: 0;
            color: var(--muted);
            font-size: 18px;
            line-height: 1.8;
            max-width: 620px;
        }

        .secure-points {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-top: 38px;
        }

        .secure-box {
            border: 1px solid rgba(215,181,109,.24);
            background: rgba(0,0,0,.28);
            border-radius: 18px;
            padding: 18px;
        }

        .secure-box strong {
            color: var(--gold-light);
            display: block;
            margin-bottom: 6px;
        }

        .secure-box span {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .login-card {
            border: 1px solid var(--border);
            background: rgba(255,255,255,.045);
            border-radius: 32px;
            padding: 34px;
            box-shadow: 0 28px 90px rgba(0,0,0,.45);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-card h2 {
            margin: 0 0 8px;
            color: var(--gold-light);
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 34px;
        }

        .login-card .subtitle {
            color: var(--muted);
            margin: 0 0 28px;
            line-height: 1.6;
        }

        .alert {
            padding: 13px 15px;
            border-radius: 14px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .alert-success {
            background: rgba(34,197,94,.12);
            border: 1px solid rgba(34,197,94,.28);
            color: #bbf7d0;
        }

        .alert-error {
            background: rgba(239,68,68,.12);
            border: 1px solid rgba(239,68,68,.28);
            color: #fecaca;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            color: var(--gold-light);
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 700;
        }

        input {
            width: 100%;
            background: #050505;
            border: 1px solid rgba(255,255,255,.14);
            color: #fff;
            border-radius: 16px;
            padding: 15px 16px;
            outline: none;
            font-size: 15px;
        }

        input:focus {
            border-color: var(--gold);
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--muted);
            margin: 5px 0 22px;
            font-size: 14px;
        }

        .remember-row input {
            width: auto;
        }

        .login-btn {
            width: 100%;
            padding: 15px 22px;
            border-radius: 999px;
            border: 0;
            background: linear-gradient(135deg, var(--gold-light), #b88b42);
            color: #050505;
            font-weight: 900;
            cursor: pointer;
            font-size: 15px;
            box-shadow: 0 15px 35px rgba(215,181,109,.22);
        }

        .back-link {
            display: block;
            text-align: center;
            color: var(--muted);
            margin-top: 20px;
            font-size: 14px;
        }

        .back-link:hover {
            color: var(--gold-light);
        }

        @media(max-width: 900px) {
            .login-wrapper {
                grid-template-columns: 1fr;
            }

            .brand-panel {
                min-height: auto;
                padding: 30px;
            }

            .secure-points {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    <section class="brand-panel">
        <div>
            <div class="brand-logo">
                <strong>COAVerify™</strong>
                <span>Secure Admin Verification Panel</span>
            </div>

            <h1>Manage verified purity reports with confidence.</h1>

            <p>
                Admin access for managing peptide purity COA verification records,
                batch authentication entries, submissions, and branded COAVerify™ reports.
            </p>

            <div class="secure-points">
                <div class="secure-box">
                    <strong>Batch ID</strong>
                    <span>Exact-match verification records.</span>
                </div>

                <div class="secure-box">
                    <strong>Purity %</strong>
                    <span>Clean verified purity result display.</span>
                </div>

                <div class="secure-box">
                    <strong>Reports</strong>
                    <span>Premium COAVerify™ report format.</span>
                </div>
            </div>
        </div>
    </section>

    <section class="login-card">
        <h2>Admin Login</h2>
        <p class="subtitle">Enter your secure credentials to continue.</p>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <div class="form-group">
                <label>Email Address</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="admin@coaverify.com"
                    required
                    autofocus
                >
            </div>

            <div class="form-group">
                <label>Password</label>
                <input
                    type="password"
                    name="password"
                    placeholder="Enter password"
                    required
                >
            </div>

            <label class="remember-row">
                <input type="checkbox" name="remember" value="1">
                Remember me
            </label>

            <button type="submit" class="login-btn">
                Login to Admin Panel
            </button>
        </form>

        <a href="{{ route('home') }}" class="back-link">← Back to Website</a>
    </section>

</div>

</body>
</html>