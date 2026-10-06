@extends('admin.layouts.app')

@section('title', 'Add Service Category - COAVerify™')
@section('page_title', 'Add Service Category')
@section('page_subtitle', 'Create a new public sample verification category.')

@section('page_actions')
    <a href="{{ route('admin.service-categories.index') }}" class="btn btn-outline">Back</a>
@endsection

@section('content')

<div class="panel">
    <form method="POST" action="{{ route('admin.service-categories.store') }}">
        @csrf

        <div class="form-grid">
            <div class="form-group">
                <label>Category Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Example: Peptides" required>
            </div>

            <div class="form-group">
                <label>Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}" placeholder="peptides">
                <span class="help">Leave blank to auto-generate from title.</span>
            </div>

            <div class="form-group">
                <label>Badge</label>
                <input type="text" name="badge" value="{{ old('badge') }}" placeholder="Popular / Category / Review">
            </div>

            <div class="form-group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
            </div>

            <div class="form-group full">
                <label>Subtitle</label>
                <input type="text" name="subtitle" value="{{ old('subtitle') }}" placeholder="Short one-line description">
            </div>

            <div class="form-group full">
                <label>Description</label>
                <textarea name="description" placeholder="Category description for public page">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label>Meta Title</label>
                <input type="text" name="meta_title" value="{{ old('meta_title') }}" placeholder="SEO title">
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="is_active">
                    <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="form-group full">
                <label>Meta Description</label>
                <textarea name="meta_description" placeholder="SEO description">{{ old('meta_description') }}</textarea>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Category</button>
            <a href="{{ route('admin.service-categories.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

@endsection