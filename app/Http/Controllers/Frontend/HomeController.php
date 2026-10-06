<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CoaReport;
use App\Models\ServiceCategory;
use App\Models\ServiceItem;

class HomeController extends Controller
{
    public function index()
    {
        $popularItems = ServiceItem::query()
            ->with('category')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('title')
            ->take(4)
            ->get();

        $categories = ServiceCategory::query()
            ->withCount(['activeItems'])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('title')
            ->take(8)
            ->get();

        $verifiedReportsCount = CoaReport::query()
            ->where('status', 'verified')
            ->count();

        return view('frontend.home', compact(
            'popularItems',
            'categories',
            'verifiedReportsCount'
        ));
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function products()
    {
        return redirect()->route('services.index');
    }

    public function contact()
    {
        return view('frontend.contact');
    }
}