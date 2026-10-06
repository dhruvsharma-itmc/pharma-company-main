<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdditionalService;
use Illuminate\Http\Request;

class AdditionalServiceController extends Controller
{
    public function index()
    {
        $additionalServices = AdditionalService::query()
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(30);

        return view('admin.additional-services.index', compact('additionalServices'));
    }

    public function create()
    {
        return view('admin.additional-services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'max:10'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        AdditionalService::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'currency' => $validated['currency'] ?? 'USD',
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.additional-services.index')
            ->with('success', 'Additional service created successfully.');
    }

    public function edit(AdditionalService $additionalService)
    {
        return view('admin.additional-services.edit', compact('additionalService'));
    }

    public function update(Request $request, AdditionalService $additionalService)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'max:10'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $additionalService->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'currency' => $validated['currency'] ?? 'USD',
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.additional-services.index')
            ->with('success', 'Additional service updated successfully.');
    }

    public function destroy(AdditionalService $additionalService)
    {
        $additionalService->delete();

        return redirect()
            ->route('admin.additional-services.index')
            ->with('success', 'Additional service deleted successfully.');
    }
}