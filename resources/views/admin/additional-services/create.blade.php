@extends('admin.layouts.app')

@section('title', 'Add Additional Service - COAVerify™')
@section('page_title', 'Add Additional Service')
@section('page_subtitle', 'Create an optional add-on service for order pages.')

@section('page_actions')
    <a href="{{ route('admin.additional-services.index') }}" class="btn btn-outline">Back</a>
@endsection

@section('content')

<div class="panel">
    <form method="POST" action="{{ route('admin.additional-services.store') }}">
        @csrf

        <div class="form-grid">
            <div class="form-group full">
                <label>Service Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Example: Raw Data" required>
            </div>

            <div class="form-group">
                <label>Price *</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', 0) }}" min="0" required>
            </div>

            <div class="form-group">
                <label>Currency</label>
                <input type="text" name="currency" value="{{ old('currency', 'USD') }}">
            </div>

            <div class="form-group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="is_active">
                    <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="form-group full">
                <label>Description</label>
                <textarea name="description" placeholder="Short explanation shown to user">{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Additional Service</button>
            <a href="{{ route('admin.additional-services.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

@endsection