@extends('admin.layouts.app')

@section('title', 'Edit Additional Service - COAVerify™')
@section('page_title', 'Edit Additional Service')
@section('page_subtitle', 'Update optional add-on service details.')

@section('page_actions')
    <a href="{{ route('admin.additional-services.index') }}" class="btn btn-outline">Back</a>
@endsection

@section('content')

<div class="panel">
    <form method="POST" action="{{ route('admin.additional-services.update', $additionalService) }}">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group full">
                <label>Service Title *</label>
                <input type="text" name="title" value="{{ old('title', $additionalService->title) }}" required>
            </div>

            <div class="form-group">
                <label>Price *</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $additionalService->price) }}" min="0" required>
            </div>

            <div class="form-group">
                <label>Currency</label>
                <input type="text" name="currency" value="{{ old('currency', $additionalService->currency) }}">
            </div>

            <div class="form-group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $additionalService->sort_order) }}" min="0">
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="is_active">
                    <option value="1" {{ old('is_active', $additionalService->is_active) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('is_active', $additionalService->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="form-group full">
                <label>Description</label>
                <textarea name="description">{{ old('description', $additionalService->description) }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Additional Service</button>
            <a href="{{ route('admin.additional-services.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

@endsection