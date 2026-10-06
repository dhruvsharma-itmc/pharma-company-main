<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use App\Models\ServiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceItemController extends Controller
{
    public function index()
    {
        $items = ServiceItem::query()
            ->with('category')
            ->orderBy('service_category_id')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(30);

        return view('admin.services.items.index', compact('items'));
    }

    public function create()
    {
        $categories = ServiceCategory::query()
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('admin.services.items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_category_id' => ['required', 'exists:service_categories,id'],
            'title' => ['required', 'string', 'max:255'],

            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],

            'short_description' => ['nullable', 'string'],
            'price_label' => ['nullable', 'string', 'max:100'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'max:10'],
            'turnaround_time' => ['nullable', 'string', 'max:255'],
            'sample_requirement' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $thumbnailPath = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('service-items', 'public');
        }

        ServiceItem::create([
            'service_category_id' => $validated['service_category_id'],
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'thumbnail' => $thumbnailPath,

            'short_description' => $validated['short_description'] ?? null,
            'price_label' => $validated['price_label'] ?? 'Order Now',
            'base_price' => $validated['base_price'],
            'currency' => $validated['currency'] ?? 'USD',
            'turnaround_time' => $validated['turnaround_time'] ?? null,
            'sample_requirement' => $validated['sample_requirement'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.service-items.index')
            ->with('success', 'Service item created successfully.');
    }

    public function edit(ServiceItem $serviceItem)
    {
        $categories = ServiceCategory::query()
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('admin.services.items.edit', compact('serviceItem', 'categories'));
    }

    public function update(Request $request, ServiceItem $serviceItem)
    {
        $validated = $request->validate([
            'service_category_id' => ['required', 'exists:service_categories,id'],
            'title' => ['required', 'string', 'max:255'],

            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],

            'short_description' => ['nullable', 'string'],
            'price_label' => ['nullable', 'string', 'max:100'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'max:10'],
            'turnaround_time' => ['nullable', 'string', 'max:255'],
            'sample_requirement' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $thumbnailPath = $serviceItem->thumbnail;

        if ($request->hasFile('thumbnail')) {
            if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }

            $thumbnailPath = $request->file('thumbnail')->store('service-items', 'public');
        }

        $serviceItem->update([
            'service_category_id' => $validated['service_category_id'],
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'thumbnail' => $thumbnailPath,

            'short_description' => $validated['short_description'] ?? null,
            'price_label' => $validated['price_label'] ?? 'Order Now',
            'base_price' => $validated['base_price'],
            'currency' => $validated['currency'] ?? 'USD',
            'turnaround_time' => $validated['turnaround_time'] ?? null,
            'sample_requirement' => $validated['sample_requirement'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.service-items.index')
            ->with('success', 'Service item updated successfully.');
    }

    public function destroy(ServiceItem $serviceItem)
    {
        if ($serviceItem->thumbnail && Storage::disk('public')->exists($serviceItem->thumbnail)) {
            Storage::disk('public')->delete($serviceItem->thumbnail);
        }

        $serviceItem->delete();

        return redirect()
            ->route('admin.service-items.index')
            ->with('success', 'Service item deleted successfully.');
    }
}