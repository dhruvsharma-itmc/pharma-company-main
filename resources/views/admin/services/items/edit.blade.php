@extends('admin.layouts.app')

@section('title', 'Edit Service Item - COAVerify™')
@section('page_title', 'Edit Service Item')
@section('page_subtitle', 'Update sample review option, image, price, and public order details.')

@section('page_actions')
    <a href="{{ route('admin.service-items.index') }}" class="btn btn-outline">Back</a>
@endsection

@section('content')

<div class="panel">
    <form method="POST" action="{{ route('admin.service-items.update', $serviceItem) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group">
                <label>Category *</label>
                <select name="service_category_id" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('service_category_id', $serviceItem->service_category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $serviceItem->sort_order) }}" min="0">
            </div>

            <div class="form-group full">
                <label>Item Title *</label>
                <input type="text" name="title" value="{{ old('title', $serviceItem->title) }}" required>
            </div>

            <div class="form-group full">
                <label>Service Image</label>

                @if($serviceItem->thumbnail)
                    <div style="margin-bottom:12px;">
                        <img
                            src="{{ asset('storage/' . $serviceItem->thumbnail) }}"
                            alt="{{ $serviceItem->title }}"
                            style="max-width:220px;max-height:140px;border:1px solid rgba(215,181,109,.35);border-radius:14px;padding:6px;background:#000;object-fit:cover;"
                        >
                    </div>
                @endif

                <input type="file" name="thumbnail" accept=".jpg,.jpeg,.png,.webp">
                <span class="help">
                    Upload new image only if you want to replace old image.
                </span>
            </div>

            <div class="form-group">
                <label>Base Price *</label>
                <input type="number" step="0.01" name="base_price" value="{{ old('base_price', $serviceItem->base_price) }}" min="0" required>
            </div>

            <div class="form-group">
                <label>Currency</label>
                <input type="text" name="currency" value="{{ old('currency', $serviceItem->currency) }}">
            </div>

            <div class="form-group">
                <label>Button / Price Label</label>
                <input type="text" name="price_label" value="{{ old('price_label', $serviceItem->price_label) }}">
            </div>

            <div class="form-group">
                <label>Turnaround Time</label>
                <input type="text" name="turnaround_time" value="{{ old('turnaround_time', $serviceItem->turnaround_time) }}">
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="is_active">
                    <option value="1" {{ old('is_active', $serviceItem->is_active) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('is_active', $serviceItem->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="form-group full">
                <label>Short Description</label>
                <textarea name="short_description">{{ old('short_description', $serviceItem->short_description) }}</textarea>
            </div>

            <div class="form-group full">
                <label>Sample Requirement</label>
                <textarea name="sample_requirement">{{ old('sample_requirement', $serviceItem->sample_requirement) }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Service Item</button>
            <a href="{{ route('admin.service-items.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

@endsection