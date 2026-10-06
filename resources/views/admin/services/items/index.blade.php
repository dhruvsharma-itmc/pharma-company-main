@extends('admin.layouts.app')

@section('title', 'Service Items - COAVerify™')
@section('page_title', 'Service Items')
@section('page_subtitle', 'Manage sample review options displayed inside each service category.')

@section('page_actions')
    <a href="{{ route('admin.service-items.create') }}" class="btn btn-primary">Add Service Item</a>
@endsection

@section('content')

<div class="panel">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Item</th>
                    <th>Category</th>
                    <th>Price / Label</th>
                    <th>Status</th>
                    <th style="width:170px;">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>{{ $item->sort_order }}</td>

                        <td>
                            <strong style="color:#fff;">{{ $item->title }}</strong><br>
                            <span style="color:#b9b9b9;">{{ $item->short_description }}</span>
                        </td>

                        <td>{{ $item->category?->title ?? '-' }}</td>
                        <td>{{ $item->price_label ?? 'Request Review' }}</td>

                        <td>
                            @if($item->is_active)
                                <span class="status-active">Active</span>
                            @else
                                <span class="status-inactive">Inactive</span>
                            @endif
                        </td>

                        <td>
                            <div class="action-row">
                                <a href="{{ route('admin.service-items.edit', $item) }}" class="btn btn-primary">
                                    Edit
                                </a>

                                <form method="POST" action="{{ route('admin.service-items.destroy', $item) }}" onsubmit="return confirm('Delete this service item?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No service items found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:18px;">
        {{ $items->links() }}
    </div>
</div>

@endsection