@extends('admin.layouts.app')

@section('title', 'Add Service Item - COAVerify™')
@section('page_title', 'Add Service Item')
@section('page_subtitle', 'Create a new paid sample review option under a service category.')

@section('page_actions')
    <a href="{{ route('admin.service-items.index') }}" class="btn btn-outline">Back</a>
@endsection

@section('content')

<div class="panel">
    <form method="POST" action="{{ route('admin.service-items.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-grid">
            <div class="form-group">
                <label>Category *</label>
                <select name="service_category_id" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('service_category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
            </div>

            <div class="form-group full">
                <label>Item Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Example: Adamax Analysis" required>
            </div>

            <div class="form-group full">
                <label>Service Image</label>
                <input type="file" name="thumbnail" accept=".jpg,.jpeg,.png,.webp">
                <span class="help">
                    Upload service image. Allowed: JPG, PNG, WEBP. Recommended size: 600 x 400px.
                </span>
            </div>

            <div class="form-group">
                <label>Base Price *</label>
                <input type="number" step="0.01" name="base_price" value="{{ old('base_price', 380) }}" min="0" required>
            </div>

            <div class="form-group">
                <label>Currency</label>
                <input type="text" name="currency" value="{{ old('currency', 'USD') }}" placeholder="USD">
            </div>

            <div class="form-group">
                <label>Button / Price Label</label>
                <input type="text" name="price_label" value="{{ old('price_label', 'Order Now') }}" placeholder="Order Now">
            </div>

            <div class="form-group">
                <label>Turnaround Time</label>
                <input type="text" name="turnaround_time" value="{{ old('turnaround_time') }}" placeholder="Example: 5 business days">
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="is_active">
                    <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="form-group full">
                <label>Short Description</label>
                <textarea name="short_description" placeholder="Short display text for public category page">{{ old('short_description') }}</textarea>
            </div>

            <div class="form-group full">
                <label>Sample Requirement</label>
                <textarea name="sample_requirement" placeholder="Example: 1 unopened vial or 30mg sealed sample">{{ old('sample_requirement') }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Service Item</button>
            <a href="{{ route('admin.service-items.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

@endsection