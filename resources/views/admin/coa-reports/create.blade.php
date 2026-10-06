@extends('admin.layouts.app')

@section('title', 'Add COA Report - COAVerify™')
@section('page_title', 'Add COA Report')
@section('page_subtitle', 'Create a new public batch verification record.')

@section('page_actions')
    <a href="{{ route('admin.coa-reports.index') }}" class="btn btn-outline">Back</a>
@endsection

@section('content')

@php
    $sourceSubmission = $sourceSubmission ?? null;
@endphp

<div class="panel">
    @if($sourceSubmission)
        <div class="alert alert-success">
            Creating COA report from sample submission #{{ $sourceSubmission->id }}.
        </div>
    @endif

    <form method="POST" action="{{ route('admin.coa-reports.store') }}" enctype="multipart/form-data">
        @csrf
        @if($sourceSubmission)
            <input type="hidden" name="source_sample_submission_id" value="{{ $sourceSubmission->id }}">
        @endif

        <div class="form-grid">
            <div class="form-group">
                <label>Batch Number *</label>
                <input type="text" name="batch_number" value="{{ old('batch_number', $sourceSubmission?->batch_number) }}" placeholder="EP0861" required>
            </div>

            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="verified" {{ old('status', 'verified') === 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="revoked" {{ old('status') === 'revoked' ? 'selected' : '' }}>Revoked</option>
                </select>
            </div>

            <div class="form-group">
                <label>Product Name *</label>
                <input type="text" name="product_name" value="{{ old('product_name', $sourceSubmission?->product_name) }}" placeholder="RETATRUTIDE" required>
            </div>

            <div class="form-group">
                <label>Strength</label>
                <input type="text" name="strength" value="{{ old('strength', $sourceSubmission?->strength) }}" placeholder="30mg">
            </div>

            <div class="form-group">
                <label>Purity %</label>
                <input type="number" step="0.01" min="0" max="100" name="purity_percent" value="{{ old('purity_percent') }}" placeholder="99.70">
            </div>

            <div class="form-group">
                <label>Verification Date</label>
                <input type="date" name="verification_date" value="{{ old('verification_date', now()->toDateString()) }}">
            </div>

            <div class="form-group">
                <label>Sample Received Date</label>
                <input
                    type="date"
                    name="sample_received_date"
                    value="{{ old('sample_received_date', $sourceSubmission?->created_at ? $sourceSubmission->created_at->format('Y-m-d') : '') }}"
                >
                <span class="help">This date will show dynamically on the generated certificate/report.</span>
            </div>

            <div class="form-group">
                <label>Client / Company Name *</label>
                <input type="text" name="client_company_name" value="{{ old('client_company_name', $sourceSubmission?->company_name) }}" placeholder="Elite Pharm USA" required>
            </div>

            <div class="form-group">
                <label>Brand Name on Report</label>
                <input type="text" name="report_brand_name" value="{{ old('report_brand_name', $sourceSubmission?->company_name) }}" placeholder="ELITE PHARM USA">
            </div>

            <div class="form-group">
                <label>Expiry Label</label>
                <input type="text" name="expiry_label" value="{{ old('expiry_label') }}" placeholder="4/28">
            </div>

            <div class="form-group">
                <label>Usage Text</label>
                <input type="text" name="usage_text" value="{{ old('usage_text', 'For Research Use Only') }}" placeholder="For Research Use Only">
            </div>

            <div class="form-group full">
                <label>Blend Title</label>
                <input type="text" name="blend_title" value="{{ old('blend_title') }}" placeholder="Proprietary Peptide Blend / Verified Peptide Sample">
            </div>

            <div class="form-group full">
                <label>Blend Breakdown</label>
                <input type="text" name="blend_breakdown" value="{{ old('blend_breakdown', $sourceSubmission?->strength ? 'Strength: ' . $sourceSubmission->strength : '') }}" placeholder="80mg Total (10+10+50+10) / Purity Verified: 99.70%">
            </div>

            <div class="form-group">
                <label>Optional Uploaded PDF</label>
                <input type="file" name="report_pdf" accept=".pdf">
                <span class="help">Optional PDF upload. System generated report will still work.</span>
            </div>

            <div class="form-group">
                <label>Optional Label Image</label>
                @if($sourceSubmission?->sample_label_image)
                    <div style="margin-bottom:10px;">
                        <img
                            src="{{ asset('storage/' . $sourceSubmission->sample_label_image) }}"
                            alt="Source Label"
                            style="max-width:180px;max-height:110px;border:1px solid rgba(215,181,109,.32);border-radius:12px;padding:6px;background:#000;"
                        >
                        <span class="help">This submission label will be copied automatically if you do not upload a replacement.</span>
                    </div>
                @endif
                <input type="file" name="sample_label_image" accept=".jpg,.jpeg,.png,.webp">
                <span class="help">Optional label image if you want to store original label.</span>
            </div>

            <div class="form-group full">
                <label>Internal Notes</label>
                <textarea name="notes" placeholder="Internal notes only">{{ old('notes', $sourceSubmission ? trim("Created from sample submission #{$sourceSubmission->id}\n" . ($sourceSubmission->notes ?: '')) : '') }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save COA Report</button>
            <a href="{{ route('admin.coa-reports.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

@endsection
