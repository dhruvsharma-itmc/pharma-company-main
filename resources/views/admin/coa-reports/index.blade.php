@extends('admin.layouts.app')

@section('title', 'COA Reports - COAVerify™')
@section('page_title', 'COA Reports')
@section('page_subtitle', 'Create and manage public batch verification records.')

@section('page_actions')
    <a href="{{ route('admin.coa-reports.create') }}" class="btn btn-primary">Add COA Report</a>
@endsection

@section('content')

<div class="panel" style="margin-bottom:18px;">
    <form method="GET" action="{{ route('admin.coa-reports.index') }}">
        <div class="form-grid">
            <div class="form-group">
                <label>Search</label>
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Batch, product, company..."
                >
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="">All Status</option>
                    <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="revoked" {{ request('status') === 'revoked' ? 'selected' : '' }}>Revoked</option>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.coa-reports.index') }}" class="btn btn-outline">Reset</a>
        </div>
    </form>
</div>

<div class="panel">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Batch</th>
                    <th>Product</th>
                    <th>Purity</th>
                    <th>Company</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th style="width:240px;">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($reports as $report)
                    <tr>
                        <td>
                            <strong style="color:#fff;">{{ $report->batch_number }}</strong>
                        </td>

                        <td>
                            <strong style="color:#fff;">{{ $report->product_name }}</strong><br>
                            <span style="color:#b9b9b9;">{{ $report->strength ?: '-' }}</span>
                        </td>

                        <td>
                            @if(!is_null($report->purity_percent))
                                {{ number_format((float) $report->purity_percent, 2) }}%
                            @else
                                -
                            @endif
                        </td>

                        <td>{{ $report->client_company_name }}</td>

                        <td>
                            <strong style="color:#fff;">
                                {{ $report->verification_date ? $report->verification_date->format('d M Y') : '-' }}
                            </strong><br>
                            <span style="color:#b9b9b9;">
                                Received: {{ $report->sample_received_date ? $report->sample_received_date->format('d M Y') : '-' }}
                            </span>
                        </td>

                        <td>
                            @if($report->status === 'verified')
                                <span class="status-active">Verified</span>
                            @elseif($report->status === 'pending')
                                <span style="color:#fde68a;font-weight:900;">Pending</span>
                            @else
                                <span class="status-inactive">Revoked</span>
                            @endif
                        </td>

                        <td>
                            <div class="action-row">
                                <a
                                    href="{{ route('verify.index') }}"
                                    target="_blank"
                                    class="btn btn-outline"
                                >
                                    Verify
                                </a>

                                @if($report->status === 'verified')
                                    <a
                                        href="{{ route('verify.report.download', $report) }}"
                                        target="_blank"
                                        class="btn btn-outline"
                                    >
                                        PDF
                                    </a>
                                @endif

                                <a href="{{ route('admin.coa-reports.edit', $report) }}" class="btn btn-primary">
                                    Edit
                                </a>

                                <form method="POST" action="{{ route('admin.coa-reports.destroy', $report) }}" onsubmit="return confirm('Delete this COA report?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No COA reports found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:18px;">
        {{ $reports->links() }}
    </div>
</div>

@endsection
