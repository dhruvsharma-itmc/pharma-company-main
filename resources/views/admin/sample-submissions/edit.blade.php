@extends('admin.layouts.app')

@section('title', 'Edit Sample Submission - COAVerify™')
@section('page_title', 'Edit Sample Submission')
@section('page_subtitle', 'Update sample details, status, uploaded files, and internal notes.')

@section('page_actions')
    <a href="{{ route('admin.sample-submissions.show', $sampleSubmission) }}" class="btn btn-outline">View</a>
    <a href="{{ route('admin.sample-submissions.index') }}" class="btn btn-outline">Back</a>
@endsection

@section('content')

<div class="panel">
    <form method="POST" action="{{ route('admin.sample-submissions.update', $sampleSubmission) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group">
                <label>Company Name *</label>
                <input type="text" name="company_name" value="{{ old('company_name', $sampleSubmission->company_name) }}" required>
            </div>

            <div class="form-group">
                <label>Contact Name</label>
                <input type="text" name="contact_name" value="{{ old('contact_name', $sampleSubmission->contact_name) }}">
            </div>

            <div class="form-group">
                <label>Email Address *</label>
                <input type="email" name="email" value="{{ old('email', $sampleSubmission->email) }}" required>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone', $sampleSubmission->phone) }}">
            </div>

            <div class="form-group">
                <label>Product Name *</label>
                <input type="text" name="product_name" value="{{ old('product_name', $sampleSubmission->product_name) }}" required>
            </div>

            <div class="form-group">
                <label>Strength</label>
                <input type="text" name="strength" value="{{ old('strength', $sampleSubmission->strength) }}">
            </div>

            <div class="form-group">
                <label>Batch Number</label>
                <input type="text" name="batch_number" value="{{ old('batch_number', $sampleSubmission->batch_number) }}">
            </div>

            <div class="form-group">
                <label>Status *</label>
                <select name="status" required>
                    <option value="new" {{ old('status', $sampleSubmission->status) === 'new' ? 'selected' : '' }}>New</option>
                    <option value="under_review" {{ old('status', $sampleSubmission->status) === 'under_review' ? 'selected' : '' }}>Under Review</option>
                    <option value="verified" {{ old('status', $sampleSubmission->status) === 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="rejected" {{ old('status', $sampleSubmission->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <div class="form-group">
                <label>Replace Sample Label Image</label>

                @if($sampleSubmission->sample_label_image)
                    <div style="margin-bottom:10px;">
                        <img
                            src="{{ asset('storage/' . $sampleSubmission->sample_label_image) }}"
                            alt="Sample Label"
                            style="max-width:180px;max-height:110px;border:1px solid rgba(215,181,109,.32);border-radius:12px;padding:6px;background:#000;"
                        >
                    </div>
                @endif

                <input type="file" name="sample_label_image" accept=".jpg,.jpeg,.png,.webp">
                <span class="help">Allowed: JPG, PNG, WEBP. Max 10MB.</span>
            </div>

            <div class="form-group">
                <label>Replace COA / Supporting File</label>

                @if($sampleSubmission->coa_file)
                    <div style="margin-bottom:10px;">
                        <a href="{{ asset('storage/' . $sampleSubmission->coa_file) }}" target="_blank" class="btn btn-outline">
                            View Current File
                        </a>
                    </div>
                @endif

                <input type="file" name="coa_file" accept=".pdf,.jpg,.jpeg,.png,.webp">
                <span class="help">Allowed: PDF, JPG, PNG, WEBP. Max 10MB.</span>
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
                <label>Payment Reference / Transaction ID</label>
                <input type="text" name="payment_reference" value="{{ old('payment_reference', $sampleSubmission->payment_reference) }}">
            </div>

            <div class="form-group">
                <label>Replace Payment Proof</label>

                @if($sampleSubmission->payment_proof_file)
                    <div style="margin-bottom:10px;">
                        <a href="{{ asset('storage/' . $sampleSubmission->payment_proof_file) }}" target="_blank" class="btn btn-outline">
                            View Current Proof
                        </a>
                    </div>
                @endif

                <input type="file" name="payment_proof_file" accept=".pdf,.jpg,.jpeg,.png,.webp">
                <span class="help">Allowed: PDF, JPG, PNG, WEBP. Max 10MB.</span>
            </div>

            <div class="form-group full">
                <label>Notes</label>
                <textarea name="notes">{{ old('notes', $sampleSubmission->notes) }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Submission</button>
            <a href="{{ route('admin.sample-submissions.show', $sampleSubmission) }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

@endsection
