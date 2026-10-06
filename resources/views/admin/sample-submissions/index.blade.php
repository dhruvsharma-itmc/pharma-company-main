@extends('admin.layouts.app')

@section('title', 'Sample Submissions - COAVerify™')
@section('page_title', 'Sample Submissions')
@section('page_subtitle', 'Review submitted sample details, uploaded label images, COA files, and verification status.')

@section('content')

<div class="panel" style="margin-bottom:18px;">
    <form method="GET" action="{{ route('admin.sample-submissions.index') }}">
        <div class="form-grid">
            <div class="form-group">
                <label>Search</label>
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Company, product, batch, email..."
                >
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="">All Status</option>
                    <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>New</option>
                    <option value="under_review" {{ request('status') === 'under_review' ? 'selected' : '' }}>Under Review</option>
                    <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.sample-submissions.index') }}" class="btn btn-outline">Reset</a>
        </div>
    </form>
</div>

<div class="panel">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Company</th>
                    <th>Product</th>
                    <th>Batch</th>
                    <th>Contact</th>
                    <th>Files</th>
                    <th>Status</th>
                    <th style="width:220px;">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($submissions as $submission)
                    <tr>
                        <td>
                            {{ $submission->created_at ? $submission->created_at->format('d M Y') : '-' }}<br>
                            <span style="color:#b9b9b9;">
                                {{ $submission->created_at ? $submission->created_at->format('h:i A') : '' }}
                            </span>
                        </td>

                        <td>
                            <strong style="color:#fff;">{{ $submission->company_name }}</strong><br>
                            <span style="color:#b9b9b9;">{{ $submission->contact_name ?: '-' }}</span>
                        </td>

                        <td>
                            <strong style="color:#fff;">{{ $submission->product_name }}</strong><br>
                            <span style="color:#b9b9b9;">{{ $submission->strength ?: '-' }}</span>
                        </td>

                        <td>{{ $submission->batch_number ?: '-' }}</td>

                        <td>
                            {{ $submission->email }}<br>
                            <span style="color:#b9b9b9;">{{ $submission->phone ?: '-' }}</span>
                        </td>

                        <td>
                            @if($submission->sample_label_image)
                                <a href="{{ asset('storage/' . $submission->sample_label_image) }}" target="_blank" class="btn btn-outline">
                                    Label
                                </a>
                            @endif

                            @if($submission->coa_file)
                                <a href="{{ asset('storage/' . $submission->coa_file) }}" target="_blank" class="btn btn-outline">
                                    File
                                </a>
                            @endif

                            @if($submission->payment_proof_file)
                                <a href="{{ asset('storage/' . $submission->payment_proof_file) }}" target="_blank" class="btn btn-outline">
                                    Proof
                                </a>
                            @endif

                            @if(!$submission->sample_label_image && !$submission->coa_file && !$submission->payment_proof_file)
                                -
                            @endif

                            @if($submission->payment_amount)
                                <div style="color:#f7dc95;margin-top:8px;font-weight:900;">
                                    {{ $submission->payment_currency ?: 'USD' }} {{ number_format((float) $submission->payment_amount, 2) }}
                                </div>
                                <span style="color:#b9b9b9;">{{ $submission->payment_method_label ?: 'Payment' }}</span>
                            @endif
                        </td>

                        <td>
                            @if($submission->status === 'new')
                                <span style="color:#93c5fd;font-weight:900;">New</span>
                            @elseif($submission->status === 'under_review')
                                <span style="color:#fde68a;font-weight:900;">Under Review</span>
                            @elseif($submission->status === 'verified')
                                <span class="status-active">Verified</span>
                            @else
                                <span class="status-inactive">Rejected</span>
                            @endif
                        </td>

                        <td>
                            <div class="action-row">
                                <a href="{{ route('admin.sample-submissions.show', $submission) }}" class="btn btn-outline">
                                    View
                                </a>

                                <a href="{{ route('admin.sample-submissions.edit', $submission) }}" class="btn btn-primary">
                                    Edit
                                </a>

                                <form method="POST" action="{{ route('admin.sample-submissions.destroy', $submission) }}" onsubmit="return confirm('Delete this sample submission?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">No sample submissions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:18px;">
        {{ $submissions->links() }}
    </div>
</div>

@endsection
