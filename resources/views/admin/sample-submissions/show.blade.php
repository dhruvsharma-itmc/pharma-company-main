@extends('admin.layouts.app')

@section('title', 'View Sample Submission - COAVerify™')
@section('page_title', 'View Sample Submission')
@section('page_subtitle', 'Review submitted product information, files, and client details.')

@section('page_actions')
    <a href="{{ route('admin.sample-submissions.edit', $sampleSubmission) }}" class="btn btn-primary">Edit Submission</a>
    <a href="{{ route('admin.sample-submissions.index') }}" class="btn btn-outline">Back</a>
@endsection

@section('content')

<div class="panel">
    <div class="form-grid">
        <div class="form-group">
            <label>Company Name</label>
            <input type="text" value="{{ $sampleSubmission->company_name }}" readonly>
        </div>

        <div class="form-group">
            <label>Contact Name</label>
            <input type="text" value="{{ $sampleSubmission->contact_name ?: '-' }}" readonly>
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <input type="text" value="{{ $sampleSubmission->email }}" readonly>
        </div>

        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" value="{{ $sampleSubmission->phone ?: '-' }}" readonly>
        </div>

        <div class="form-group">
            <label>Product Name</label>
            <input type="text" value="{{ $sampleSubmission->product_name }}" readonly>
        </div>

        <div class="form-group">
            <label>Strength</label>
            <input type="text" value="{{ $sampleSubmission->strength ?: '-' }}" readonly>
        </div>

        <div class="form-group">
            <label>Batch Number</label>
            <input type="text" value="{{ $sampleSubmission->batch_number ?: '-' }}" readonly>
        </div>

        <div class="form-group">
            <label>Status</label>
            <input type="text" value="{{ $sampleSubmission->status_label }}" readonly>
        </div>

        <div class="form-group">
            <label>Payment Amount</label>
            <input
                type="text"
                value="{{ $sampleSubmission->payment_amount ? (($sampleSubmission->payment_currency ?: 'USD') . ' ' . number_format((float) $sampleSubmission->payment_amount, 2)) : '-' }}"
                readonly
            >
        </div>

        <div class="form-group">
            <label>Payment Method</label>
            <input type="text" value="{{ $sampleSubmission->payment_method_label ?: '-' }}" readonly>
        </div>

        <div class="form-group">
            <label>Payment Reference</label>
            <input type="text" value="{{ $sampleSubmission->payment_reference ?: '-' }}" readonly>
        </div>

        <div class="form-group full">
            <label>Notes</label>
            <textarea readonly>{{ $sampleSubmission->notes ?: '-' }}</textarea>
        </div>
    </div>
</div>

<div class="panel" style="margin-top:18px;">
    <h2 style="margin:0 0 18px;color:#f7dc95;font-family:Georgia,'Times New Roman',serif;">
        Uploaded Files
    </h2>

    <div class="form-grid">
        <div class="form-group">
            <label>Sample Label Image</label>

            @if($sampleSubmission->sample_label_image)
                <a href="{{ asset('storage/' . $sampleSubmission->sample_label_image) }}" target="_blank">
                    <img
                        src="{{ asset('storage/' . $sampleSubmission->sample_label_image) }}"
                        alt="Sample Label"
                        style="max-width:100%;max-height:260px;border:1px solid rgba(215,181,109,.35);border-radius:18px;padding:8px;background:#000;"
                    >
                </a>

                <div style="margin-top:12px;">
                    <a href="{{ asset('storage/' . $sampleSubmission->sample_label_image) }}" target="_blank" class="btn btn-outline">
                        Open Label Image
                    </a>
                </div>
            @else
                <input type="text" value="No label image uploaded" readonly>
            @endif
        </div>

        <div class="form-group">
            <label>COA / Supporting File</label>

            @if($sampleSubmission->coa_file)
                <a href="{{ asset('storage/' . $sampleSubmission->coa_file) }}" target="_blank" class="btn btn-primary">
                    Open Uploaded File
                </a>

                <span class="help">
                    File path: {{ $sampleSubmission->coa_file }}
                </span>
            @else
                <input type="text" value="No COA/supporting file uploaded" readonly>
            @endif
        </div>

        <div class="form-group">
            <label>Payment Proof</label>

            @if($sampleSubmission->payment_proof_file)
                <a href="{{ asset('storage/' . $sampleSubmission->payment_proof_file) }}" target="_blank" class="btn btn-primary">
                    Open Payment Proof
                </a>

                <span class="help">
                    File path: {{ $sampleSubmission->payment_proof_file }}
                </span>
            @else
                <input type="text" value="No payment proof uploaded" readonly>
            @endif
        </div>
    </div>
</div>

@php
    $cartSnapshot = $sampleSubmission->cart_snapshot ?? [];
@endphp

@if(!empty($cartSnapshot['items']))
    <div class="panel" style="margin-top:18px;">
        <h2 style="margin:0 0 18px;color:#f7dc95;font-family:Georgia,'Times New Roman',serif;">
            Cart Snapshot
        </h2>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Add-ons</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($cartSnapshot['items'] as $item)
                        <tr>
                            <td>
                                <strong style="color:#fff;">{{ $item['service_title'] ?? '-' }}</strong><br>
                                <span style="color:#b9b9b9;">{{ $item['category_title'] ?? '-' }}</span>
                            </td>
                            <td>
                                @forelse(($item['additional_services'] ?? []) as $addon)
                                    {{ $addon['title'] ?? '-' }}<br>
                                @empty
                                    -
                                @endforelse
                            </td>
                            <td>
                                {{ $item['currency'] ?? ($sampleSubmission->payment_currency ?: 'USD') }}
                                {{ number_format((float) ($item['line_total'] ?? 0), 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

<div class="panel" style="margin-top:18px;">
    <h2 style="margin:0 0 12px;color:#f7dc95;font-family:Georgia,'Times New Roman',serif;">
        Quick Next Step
    </h2>

    <p style="color:#b9b9b9;line-height:1.8;margin:0 0 18px;">
        After reviewing this submission, you can create a verified COA report manually from the COA Reports section.
    </p>

    @if(!empty($existingCoaReport))
        <div class="form-actions">
            <a href="{{ route('admin.coa-reports.edit', $existingCoaReport) }}" class="btn btn-primary">
                Edit Existing COA Report
            </a>

            @if($existingCoaReport->status === 'verified')
                <a href="{{ route('verify.report.download', $existingCoaReport) }}" target="_blank" class="btn btn-outline">
                    Download COA PDF
                </a>
            @endif
        </div>
    @else
        <a href="{{ route('admin.coa-reports.create', ['sample_submission_id' => $sampleSubmission->id]) }}" class="btn btn-primary">
            Create COA Report
        </a>
    @endif
</div>

@endsection
