@extends('admin.layouts.app')

@section('title', 'Service Categories - COAVerify™')
@section('page_title', 'Service Categories')
@section('page_subtitle', 'Manage public “What We Verify” category cards.')

@section('page_actions')
    <a href="{{ route('admin.service-categories.create') }}" class="btn btn-primary">Add Category</a>
@endsection

@section('content')

<div class="panel">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Category</th>
                    <th>Slug</th>
                    <th>Badge</th>
                    <th>Items</th>
                    <th>Status</th>
                    <th style="width:190px;">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->sort_order }}</td>

                        <td>
                            <strong style="color:#fff;">{{ $category->title }}</strong><br>
                            <span style="color:#b9b9b9;">{{ $category->subtitle }}</span>
                        </td>

                        <td>{{ $category->slug }}</td>
                        <td>{{ $category->badge ?? '-' }}</td>
                        <td>{{ $category->items_count }}</td>

                        <td>
                            @if($category->is_active)
                                <span class="status-active">Active</span>
                            @else
                                <span class="status-inactive">Inactive</span>
                            @endif
                        </td>

                        <td>
                            <div class="action-row">
                                <a href="{{ route('services.show', $category->slug) }}" target="_blank" class="btn btn-outline">
                                    View
                                </a>

                                <a href="{{ route('admin.service-categories.edit', $category) }}" class="btn btn-primary">
                                    Edit
                                </a>

                                <form method="POST" action="{{ route('admin.service-categories.destroy', $category) }}" onsubmit="return confirm('Delete this category? All related items will also be deleted.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No service categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:18px;">
        {{ $categories->links() }}
    </div>
</div>

@endsection