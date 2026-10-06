@extends('admin.layouts.app')

@section('title', 'Admin Dashboard - COAVerify™')
@section('page_title', 'Verification Dashboard')
@section('page_subtitle', 'Manage verified batch records, sample categories, service items, and public verification content from one secure panel.')

@section('content')

<div class="cards">
    <div class="stat-card">
        <span>Service Categories</span>
        <strong>{{ \App\Models\ServiceCategory::count() }}</strong>
    </div>

    <div class="stat-card">
        <span>Active Categories</span>
        <strong>{{ \App\Models\ServiceCategory::where('is_active', true)->count() }}</strong>
    </div>

    <div class="stat-card">
        <span>Service Items</span>
        <strong>{{ \App\Models\ServiceItem::count() }}</strong>
    </div>

    <div class="stat-card">
        <span>Active Items</span>
        <strong>{{ \App\Models\ServiceItem::where('is_active', true)->count() }}</strong>
    </div>
</div>

<div class="panel" style="margin-top:22px;">
    <h2 style="margin:0 0 12px;color:#f7dc95;font-family:Georgia,'Times New Roman',serif;font-size:34px;">
        Website Service Management Ready
    </h2>

    <p style="color:#b9b9b9;line-height:1.8;margin:0;max-width:900px;">
        The “What We Verify” section is now dynamic. You can manage service categories and
        sample review options directly from the admin panel. Public pages will automatically
        display only active categories and active items in the selected order.
    </p>

    <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:22px;">
        <a href="{{ route('admin.service-categories.index') }}" class="btn btn-primary">
            Manage Categories
        </a>

        <a href="{{ route('admin.service-items.index') }}" class="btn btn-outline">
            Manage Service Items
        </a>

        <a href="{{ route('services.index') }}" target="_blank" class="btn btn-outline">
            View Public Services
        </a>
    </div>
</div>

@endsection