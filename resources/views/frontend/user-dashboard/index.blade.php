@extends('frontend.layouts.app')

@section('title', 'My Dashboard - COAVerify™')
@section('meta_description', 'View your COAVerify sample submissions, payment proof status, and COA report downloads.')

@push('styles')
<style>
    .user-dashboard {
        padding: 58px 0 90px;
    }

    .dashboard-head {
        display: flex;
        justify-content: space-between;
        gap: 18px;
        align-items: end;
        margin-bottom: 24px;
    }

    .dashboard-head h1 {
        margin: 0;
        font-family: Georgia, 'Times New Roman', serif;
        font-size: clamp(34px, 5vw, 56px);
    }

    .dashboard-head p {
        margin: 8px 0 0;
        color: var(--muted);
        line-height: 1.7;
    }

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 22px;
    }

    .stat-card,
    .submission-card {
        border: 1px solid rgba(215,181,109,.28);
        border-radius: 22px;
        background: linear-gradient(180deg, rgba(255,255,255,.052), rgba(255,255,255,.018));
        box-shadow: 0 18px 55px rgba(0,0,0,.24);
    }

    .stat-card {
        padding: 20px;
    }

    .stat-card span {
        display: block;
        color: var(--muted);
        font-size: 13px;
        margin-bottom: 10px;
        font-weight: 800;
    }

    .stat-card strong {
        display: block;
        color: var(--gold-light);
        font-size: 34px;
    }

    .submission-list {
        display: grid;
        gap: 16px;
    }

    .submission-card {
        padding: 22px;
        display: grid;
        grid-template-columns: 1.2fr .8fr auto;
        gap: 18px;
        align-items: center;
    }

    .submission-card h2 {
        margin: 0 0 8px;
        color: #fff;
        font-size: 24px;
    }

    .submission-card p {
        margin: 0;
        color: var(--muted);
        line-height: 1.6;
        font-size: 14px;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        border: 1px solid rgba(215,181,109,.28);
        border-radius: 999px;
        padding: 8px 11px;
        color: var(--gold-light);
        background: rgba(215,181,109,.08);
        font-size: 12px;
        font-weight: 900;
        margin: 4px 6px 4px 0;
    }

    .status-green {
        color: #bbf7d0;
        border-color: rgba(34,197,94,.30);
        background: rgba(34,197,94,.10);
    }

    .status-red {
        color: #fecaca;
        border-color: rgba(239,68,68,.30);
        background: rgba(239,68,68,.10);
    }

    .empty-box {
        text-align: center;
        padding: 44px 20px;
        color: var(--muted);
        line-height: 1.8;
        border: 1px solid rgba(215,181,109,.24);
        border-radius: 22px;
        background: rgba(255,255,255,.025);
    }

    @media(max-width: 920px) {
        .dashboard-head,
        .submission-card {
            grid-template-columns: 1fr;
            align-items: start;
        }

        .dashboard-head {
            display: grid;
        }

        .stat-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media(max-width: 560px) {
        .stat-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

<section class="user-dashboard">
    <div class="container">
        <div class="dashboard-head">
            <div>
                <div class="premium-badge">My Dashboard</div>
                <h1>Your Sample Submissions</h1>
                <p>Track payment proof, review status, uploaded files, and COA report availability.</p>
            </div>

            <form method="POST" action="{{ route('user.logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline">Logout</button>
            </form>
        </div>

        <div class="stat-grid">
            <div class="stat-card">
                <span>Total Submissions</span>
                <strong>{{ $stats['total'] }}</strong>
            </div>
            <div class="stat-card">
                <span>Under Review</span>
                <strong>{{ $stats['under_review'] }}</strong>
            </div>
            <div class="stat-card">
                <span>Verified</span>
                <strong>{{ $stats['verified'] }}</strong>
            </div>
            <div class="stat-card">
                <span>Payment Proofs</span>
                <strong>{{ $stats['payment_proofs'] }}</strong>
            </div>
        </div>

        <div class="submission-list">
            @forelse($submissions as $submission)
                @php
                    $report = $submission->batch_number ? ($reportsByBatch[strtoupper($submission->batch_number)] ?? null) : null;
                @endphp

                <div class="submission-card">
                    <div>
                        <h2>{{ $submission->product_name }}</h2>
                        <p>
                            Batch: {{ $submission->batch_number ?: '-' }}<br>
                            Submitted: {{ $submission->created_at ? $submission->created_at->format('d M Y, h:i A') : '-' }}
                        </p>
                    </div>

                    <div>
                        <span class="status-pill">{{ $submission->status_label }}</span>
                        @if($submission->payment_proof_file)
                            <span class="status-pill status-green">Payment Proof Uploaded</span>
                        @elseif($submission->payment_amount)
                            <span class="status-pill status-red">Payment Proof Pending</span>
                        @endif

                        @if($report && $report->status === 'verified')
                            <span class="status-pill status-green">COA Ready</span>
                        @endif
                    </div>

                    <div style="display:flex;gap:10px;flex-wrap:wrap;justify-content:flex-end;">
                        <a href="{{ route('user.submissions.show', $submission) }}" class="btn btn-primary">View Details</a>
                        @if($report && $report->status === 'verified')
                            <a href="{{ route('verify.report.download', $report) }}" target="_blank" class="btn btn-outline">Download COA</a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-box">
                    No submissions found for this dashboard.
                    <br><br>
                    <a href="{{ route('sample.submit') }}" class="btn btn-primary">Submit Sample</a>
                </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
