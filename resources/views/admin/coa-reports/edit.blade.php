@extends('admin.layouts.app')

@section('title', 'Edit COA Report - COAVerify™')
@section('page_title', 'Edit COA Report')
@section('page_subtitle', 'Update batch verification record and report data.')

@section('page_actions')
    <a href="{{ route('admin.coa-reports.index') }}" class="btn btn-outline">Back</a>
@endsection

@section('content')

<div class="panel">
    <form method="POST" action="{{ route('admin.coa-reports.update', $coaReport) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group">
                <label>Batch Number *</label>
                <input type="text" name="batch_number" value="{{ old('batch_number', $coaReport->batch_number) }}" required>
            </div>

            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="verified" {{ old('status', $coaReport->status) === 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="pending" {{ old('status', $coaReport->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="revoked" {{ old('status', $coaReport->status) === 'revoked' ? 'selected' : '' }}>Revoked</option>
                </select>
            </div>

            <div class="form-group">
                <label>Product Name *</label>
                <input type="text" name="product_name" value="{{ old('product_name', $coaReport->product_name) }}" required>
            </div>

            <div class="form-group">
                <label>Strength</label>
                <input type="text" name="strength" value="{{ old('strength', $coaReport->strength) }}">
            </div>

            <div class="form-group">
                <label>Purity %</label>
                <input type="number" step="0.01" min="0" max="100" name="purity_percent" value="{{ old('purity_percent', $coaReport->purity_percent) }}">
            </div>

            <div class="form-group">
                <label>Verification Date</label>
                <input
                    type="date"
                    name="verification_date"
                    value="{{ old('verification_date', $coaReport->verification_date ? $coaReport->verification_date->format('Y-m-d') : '') }}"
                >
            </div>

            <div class="form-group">
                <label>Sample Received Date</label>
                <input
                    type="date"
                    name="sample_received_date"
                    value="{{ old('sample_received_date', $coaReport->sample_received_date ? $coaReport->sample_received_date->format('Y-m-d') : '') }}"
                >
                <span class="help">This date appears on the generated certificate/report.</span>
            </div>

            <div class="form-group">
                <label>Client / Company Name *</label>
                <input type="text" name="client_company_name" value="{{ old('client_company_name', $coaReport->client_company_name) }}" required>
            </div>

            <div class="form-group">
                <label>Brand Name on Report</label>
                <input type="text" name="report_brand_name" value="{{ old('report_brand_name', $coaReport->report_brand_name) }}">
            </div>

            <div class="form-group">
                <label>Expiry Label</label>
                <input type="text" name="expiry_label" value="{{ old('expiry_label', $coaReport->expiry_label) }}">
            </div>

            <div class="form-group">
                <label>Usage Text</label>
                <input type="text" name="usage_text" value="{{ old('usage_text', $coaReport->usage_text) }}">
            </div>

            <div class="form-group full">
                <label>Blend Title</label>
                <input type="text" name="blend_title" value="{{ old('blend_title', $coaReport->blend_title) }}">
            </div>

            <div class="form-group full">
                <label>Blend Breakdown</label>
                <input type="text" name="blend_breakdown" value="{{ old('blend_breakdown', $coaReport->blend_breakdown) }}">
            </div>

            <div class="form-group">
                <label>Replace Uploaded PDF</label>

                @if($coaReport->report_pdf)
                    <div style="margin-bottom:10px;">
                        <a href="{{ asset('storage/' . $coaReport->report_pdf) }}" target="_blank" class="btn btn-outline">
                            View Current PDF
                        </a>
                    </div>
                @endif

                <input type="file" name="report_pdf" accept=".pdf">
            </div>

            <div class="form-group">
                <label>Replace Label Image</label>

                @if($coaReport->sample_label_image)
                    <div style="margin-bottom:10px;">
                        <img
                            src="{{ asset('storage/' . $coaReport->sample_label_image) }}"
                            alt="Label"
                            style="max-width:180px;max-height:90px;border:1px solid rgba(215,181,109,.32);border-radius:12px;padding:6px;background:#000;"
                        >
                    </div>
                @endif

                <input type="file" name="sample_label_image" accept=".jpg,.jpeg,.png,.webp">
            </div>

            <div class="form-group full">
                <label>Internal Notes</label>
                <textarea name="notes">{{ old('notes', $coaReport->notes) }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update COA Report</button>

            @if($coaReport->status === 'verified')
                <a href="{{ route('verify.report.download', $coaReport) }}" target="_blank" class="btn btn-outline">
                    Download Generated PDF
                </a>
            @endif

            <a href="{{ route('admin.coa-reports.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

@endsection
