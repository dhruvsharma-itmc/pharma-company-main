@extends('admin.layouts.app')

@section('title', 'Additional Services - COAVerify™')
@section('page_title', 'Additional Services')
@section('page_subtitle', 'Manage optional add-on services shown on service order pages.')

@section('page_actions')
    <a href="{{ route('admin.additional-services.create') }}" class="btn btn-primary">Add Additional Service</a>
@endsection

@section('content')

<div class="panel">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Service</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th style="width:170px;">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($additionalServices as $service)
                    <tr>
                        <td>{{ $service->sort_order }}</td>

                        <td>
                            <strong style="color:#fff;">{{ $service->title }}</strong><br>
                            <span style="color:#b9b9b9;">{{ $service->description }}</span>
                        </td>

                        <td>{{ $service->currency }} {{ number_format((float) $service->price, 2) }}</td>

                        <td>
                            @if($service->is_active)
                                <span class="status-active">Active</span>
                            @else
                                <span class="status-inactive">Inactive</span>
                            @endif
                        </td>

                        <td>
                            <div class="action-row">
                                <a href="{{ route('admin.additional-services.edit', $service) }}" class="btn btn-primary">
                                    Edit
                                </a>

                                <form method="POST" action="{{ route('admin.additional-services.destroy', $service) }}" onsubmit="return confirm('Delete this additional service?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No additional services found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:18px;">
        {{ $additionalServices->links() }}
    </div>
</div>

@endsection