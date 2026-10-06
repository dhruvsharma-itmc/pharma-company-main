@extends('admin.layouts.app')

@section('title', 'Edit Service Category - COAVerify™')
@section('page_title', 'Edit Service Category')
@section('page_subtitle', 'Update category details displayed on the public services page.')

@section('page_actions')
    <a href="{{ route('admin.service-categories.index') }}" class="btn btn-outline">Back</a>
@endsection

@section('content')

<div class="panel">
    <form method="POST" action="{{ route('admin.service-categories.update', $serviceCategory) }}">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group">
                <label>Category Title *</label>
                <input type="text" name="title" value="{{ old('title', $serviceCategory->title) }}" required>
            </div>

            <div class="form-group">
                <label>Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $serviceCategory->slug) }}">
            </div>

            <div class="form-group">
                <label>Badge</label>
                <input type="text" name="badge" value="{{ old('badge', $serviceCategory->badge) }}">
            </div>

            <div class="form-group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $serviceCategory->sort_order) }}" min="0">
            </div>

            <div class="form-group full">
                <label>Subtitle</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $serviceCategory->subtitle) }}">
            </div>

            <div class="form-group full">
                <label>Description</label>
                <textarea name="description">{{ old('description', $serviceCategory->description) }}</textarea>
            </div>

            <div class="form-group">
                <label>Meta Title</label>
                <input type="text" name="meta_title" value="{{ old('meta_title', $serviceCategory->meta_title) }}">
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="is_active">
                    <option value="1" {{ old('is_active', $serviceCategory->is_active) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('is_active', $serviceCategory->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="form-group full">
                <label>Meta Description</label>
                <textarea name="meta_description">{{ old('meta_description', $serviceCategory->meta_description) }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Category</button>
            <a href="{{ route('admin.service-categories.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

@endsection