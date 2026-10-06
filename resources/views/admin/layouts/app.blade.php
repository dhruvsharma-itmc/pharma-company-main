<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel - COAVerify™')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        :root {
            --gold: #d7b56d;
            --gold-light: #f7dc95;
            --muted: #b9b9b9;
            --border: rgba(215,181,109,.32);
            --panel: #101010;
            --panel-soft: #151515;
            --dark: #050505;
            --green: #86efac;
            --red: #fecaca;
            --blue: #93c5fd;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background:
                radial-gradient(circle at top right, rgba(215,181,109,.10), transparent 30%),
                #050505;
            color: #fff;
            font-family: Arial, Helvetica, sans-serif;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .admin-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 280px 1fr;
        }

        .sidebar {
            background: #080808;
            border-right: 1px solid var(--border);
            padding: 26px 20px;
        }

        .brand {
            margin-bottom: 36px;
            padding-bottom: 22px;
            border-bottom: 1px solid rgba(215,181,109,.18);
        }

        .brand strong {
            display: block;
            color: var(--gold-light);
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 30px;
            letter-spacing: .4px;
        }

        .brand span {
            display: block;
            color: var(--muted);
            font-size: 11px;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            margin-top: 7px;
        }

        .side-label {
            color: rgba(255,255,255,.42);
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1.3px;
            margin: 22px 0 10px;
            padding-left: 12px;
        }

        .side-link {
            display: block;
            color: #dedede;
            padding: 13px 15px;
            border-radius: 14px;
            margin-bottom: 8px;
            border: 1px solid transparent;
            font-weight: 700;
            font-size: 14px;
            transition: .25s;
        }

        .side-link.active,
        .side-link:hover {
            background: rgba(215,181,109,.10);
            border-color: var(--border);
            color: var(--gold-light);
        }

        .main {
            padding: 28px;
        }

        .topbar {
            background:
                linear-gradient(180deg, rgba(255,255,255,.045), rgba(255,255,255,.018)),
                var(--panel);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 20px 22px;
            display: flex;
            justify-content: space-between;
            gap: 18px;
            align-items: center;
            margin-bottom: 24px;
            box-shadow: 0 18px 55px rgba(0,0,0,.28);
        }

        .topbar h1 {
            margin: 0;
            color: #fff;
            font-size: 26px;
        }

        .topbar p {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.5;
        }

        .top-actions {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn,
        .small-btn,
        .logout-btn {
            border-radius: 999px;
            padding: 11px 17px;
            cursor: pointer;
            font-weight: 800;
            font-size: 14px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border: 1px solid var(--border);
        }

        .btn-primary,
        .small-btn {
            background: linear-gradient(135deg, var(--gold-light), #b88b42);
            color: #050505;
            border-color: rgba(255,255,255,.16);
        }

        .btn-outline,
        .logout-btn {
            background: transparent;
            color: var(--gold-light);
        }

        .btn-danger {
            background: rgba(239,68,68,.12);
            color: var(--red);
            border-color: rgba(239,68,68,.28);
        }

        .alert {
            padding: 13px 15px;
            border-radius: 14px;
            margin-bottom: 18px;
            line-height: 1.6;
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

        .panel {
            background:
                linear-gradient(180deg, rgba(255,255,255,.045), rgba(255,255,255,.018)),
                var(--panel);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 16px 45px rgba(0,0,0,.22);
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        th,
        td {
            text-align: left;
            padding: 14px 12px;
            border-bottom: 1px solid rgba(255,255,255,.08);
            vertical-align: top;
        }

        th {
            color: var(--gold-light);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .7px;
        }

        td {
            color: rgba(255,255,255,.78);
            font-size: 14px;
            line-height: 1.5;
        }

        .status-active {
            color: var(--green);
            font-weight: 900;
        }

        .status-inactive {
            color: var(--red);
            font-weight: 900;
        }

        .action-row {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group.full {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            color: var(--gold-light);
            font-weight: 800;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input,
        textarea,
        select {
            width: 100%;
            background: #050505;
            border: 1px solid rgba(255,255,255,.14);
            color: #fff;
            border-radius: 16px;
            padding: 14px 15px;
            outline: none;
            font-size: 15px;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: var(--gold);
        }

        .help {
            display: block;
            color: rgba(255,255,255,.48);
            font-size: 12px;
            line-height: 1.5;
            margin-top: 7px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 8px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        .stat-card {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 24px;
        }

        .stat-card span {
            display: block;
            color: var(--muted);
            margin-bottom: 12px;
            font-size: 14px;
        }

        .stat-card strong {
            display: block;
            color: var(--gold-light);
            font-size: 36px;
        }

        nav[role="navigation"] {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            align-items: center;
            flex-wrap: wrap;
            color: var(--muted);
            font-size: 14px;
        }

        nav[role="navigation"] > div {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        nav[role="navigation"] > div:first-child {
            display: none;
        }

        nav[role="navigation"] > div:last-child > div:last-child > span {
            min-width: 0;
            min-height: 0;
            padding: 0;
            gap: 6px;
            border: 0;
            background: transparent;
        }

        nav[role="navigation"] a,
        nav[role="navigation"] span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            min-height: 38px;
            padding: 9px 12px;
            border: 1px solid rgba(215,181,109,.28);
            border-radius: 12px;
            background: rgba(255,255,255,.025);
            color: var(--gold-light);
            line-height: 1;
            font-weight: 800;
        }

        nav[role="navigation"] span[aria-current="page"] span,
        nav[role="navigation"] [aria-current="page"] {
            background: linear-gradient(135deg, var(--gold-light), #b88b42);
            color: #050505;
            border-color: rgba(255,255,255,.16);
        }

        nav[role="navigation"] span[aria-disabled="true"],
        nav[role="navigation"] span[aria-disabled="true"] span {
            color: rgba(255,255,255,.34);
            border-color: rgba(255,255,255,.10);
            background: rgba(255,255,255,.018);
        }

        nav[role="navigation"] svg {
            width: 16px;
            height: 16px;
            display: block;
        }

        nav[role="navigation"] p {
            margin: 0;
            color: var(--muted);
        }

        nav[role="navigation"] p span {
            display: inline;
            min-width: 0;
            min-height: 0;
            padding: 0;
            border: 0;
            border-radius: 0;
            background: transparent;
            color: #ffffff;
            font-weight: 900;
        }

        @media(max-width: 1000px) {
            .admin-shell {
                grid-template-columns: 1fr;
            }

            .form-grid,
            .cards {
                grid-template-columns: 1fr;
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

<div class="admin-shell">
    <aside class="sidebar">
        <div class="brand">
            <strong>COAVerify™</strong>
            <span>Verification Authority Panel</span>
        </div>

        <div class="side-label">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="side-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            Dashboard Overview
        </a>

        <div class="side-label">Website Management</div>
        <a href="{{ route('admin.service-categories.index') }}" class="side-link {{ request()->routeIs('admin.service-categories.*') ? 'active' : '' }}">
            Service Categories
        </a>

        <a href="{{ route('admin.service-items.index') }}" class="side-link {{ request()->routeIs('admin.service-items.*') ? 'active' : '' }}">
            Service Items
        </a>
        <a href="{{ route('admin.additional-services.index') }}" class="side-link {{ request()->routeIs('admin.additional-services.*') ? 'active' : '' }}">
            Additional Services
        </a>

        <div class="side-label">Verification</div>
        <a href="{{ route('admin.coa-reports.index') }}" class="side-link {{ request()->routeIs('admin.coa-reports.*') ? 'active' : '' }}">
            COA Reports
        </a>
        <a href="{{ route('admin.sample-submissions.index') }}" class="side-link {{ request()->routeIs('admin.sample-submissions.*') ? 'active' : '' }}">
            Sample Submissions
        </a>
        <a href="#" class="side-link">Activity Logs</a>
        <a href="{{ route('admin.settings.index') }}" class="side-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            Website Settings
        </a>

        <div class="side-label">Public</div>
        <a href="{{ route('home') }}" target="_blank" class="side-link">View Website</a>
    </aside>

    <main class="main">
        <div class="topbar">
            <div>
                <h1>@yield('page_title', 'Admin Panel')</h1>
                <p>@yield('page_subtitle', 'Manage COAVerify™ website and verification system.')</p>
            </div>

            <div class="top-actions">
                @yield('page_actions')

                <a href="{{ route('home') }}" target="_blank" class="small-btn">View Website</a>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <strong>Please fix the following:</strong><br>
                {{ $errors->first() }}
            </div>
        @endif

        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>
