<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AdditionalService;
use App\Models\ServiceCategory;
use App\Models\ServiceItem;

class ServiceController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::query()
            ->with(['activeItems' => function ($query) {
                $query->take(5);
            }])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('frontend.services.index', compact('categories'));
    }

    public function show(string $slug)
    {
        $category = ServiceCategory::query()
            ->with(['activeItems'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('frontend.services.show', compact('category'));
    }

    public function item(string $categorySlug, string $itemSlug)
    {
        $category = ServiceCategory::query()
            ->where('slug', $categorySlug)
            ->where('is_active', true)
            ->firstOrFail();

        $item = ServiceItem::query()
            ->where('service_category_id', $category->id)
            ->where('slug', $itemSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $additionalServices = AdditionalService::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('frontend.services.item', compact('category', 'item', 'additionalServices'));
    }
}