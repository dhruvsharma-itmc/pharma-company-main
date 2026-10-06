<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AdditionalService;
use App\Models\ServiceItem;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', [
            'items' => [],
            'subtotal' => 0,
            'currency' => 'USD',
        ]);
        $paymentMethods = SiteSetting::current()->paymentMethodsForAmount(
            (float) ($cart['subtotal'] ?? 0),
            $cart['currency'] ?? null
        );

        return view('frontend.cart.index', compact('cart', 'paymentMethods'));
    }

    public function add(Request $request, ServiceItem $serviceItem)
    {
        if (!$serviceItem->is_active) {
            abort(404);
        }

        $validated = $request->validate([
            'additional_services' => ['nullable', 'array'],
            'additional_services.*' => ['integer', 'exists:additional_services,id'],
        ]);

        $selectedAdditionalServices = AdditionalService::query()
            ->whereIn('id', $validated['additional_services'] ?? [])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $basePrice = (float) $serviceItem->base_price;
        $additionalTotal = (float) $selectedAdditionalServices->sum('price');
        $lineTotal = $basePrice + $additionalTotal;

        $cart = session()->get('cart', [
            'items' => [],
            'subtotal' => 0,
            'currency' => $serviceItem->currency ?: 'USD',
        ]);

        $cartKey = (string) Str::uuid();

        $cart['items'][$cartKey] = [
            'cart_key' => $cartKey,
            'service_item_id' => $serviceItem->id,
            'service_title' => $serviceItem->title,
            'service_slug' => $serviceItem->slug,
            'category_title' => $serviceItem->category?->title,
            'category_slug' => $serviceItem->category?->slug,
            'base_price' => $basePrice,
            'currency' => $serviceItem->currency ?: 'USD',
            'additional_services' => $selectedAdditionalServices->map(function ($service) {
                return [
                    'id' => $service->id,
                    'title' => $service->title,
                    'price' => (float) $service->price,
                    'currency' => $service->currency ?: 'USD',
                ];
            })->toArray(),
            'additional_total' => $additionalTotal,
            'line_total' => $lineTotal,
            'quantity' => 1,
        ];

        $cart['currency'] = $serviceItem->currency ?: 'USD';
        $cart['subtotal'] = collect($cart['items'])->sum('line_total');

        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Service added to cart successfully.');
    }

    public function remove(string $cartKey)
    {
        $cart = session()->get('cart', [
            'items' => [],
            'subtotal' => 0,
            'currency' => 'USD',
        ]);

        if (isset($cart['items'][$cartKey])) {
            unset($cart['items'][$cartKey]);
        }

        $cart['subtotal'] = collect($cart['items'])->sum('line_total');

        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        session()->forget('cart');

        return redirect()
            ->route('cart.index')
            ->with('success', 'Cart cleared successfully.');
    }
}
