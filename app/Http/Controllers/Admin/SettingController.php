<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $siteSetting = SiteSetting::current();

        // Old views ke liye bhi support
        $setting = $siteSetting;

        return view('admin.settings.index', compact('siteSetting', 'setting'));
    }

    public function update(Request $request)
    {
        $siteSetting = SiteSetting::current();

        $validated = $request->validate([
            'site_name' => ['nullable', 'string', 'max:255'],
            'site_tagline' => ['nullable', 'string', 'max:255'],
            'footer_disclaimer' => ['nullable', 'string', 'max:2000'],
            'payment_methods' => ['nullable', 'array'],
            'payment_methods.*.label' => ['nullable', 'string', 'max:255'],
            'payment_methods.*.type' => ['nullable', 'string', 'in:upi,link'],
            'payment_methods.*.upi_id' => ['nullable', 'string', 'max:255'],
            'payment_methods.*.payment_link' => ['nullable', 'string', 'max:1000', 'regex:/^(https?:\/\/|upi:\/\/).+/i'],
            'payment_methods.*.instructions' => ['nullable', 'string', 'max:1000'],
            'payment_methods.*.existing_qr_image' => ['nullable', 'string', 'max:1000'],
            'payment_methods.*.qr_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],

            'site_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'favicon' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,ico', 'max:2048'],

            'home_hero_badge' => ['nullable', 'string', 'max:255'],
            'home_hero_title' => ['nullable', 'string', 'max:255'],
            'home_hero_highlight' => ['nullable', 'string', 'max:255'],
            'home_hero_description' => ['nullable', 'string', 'max:3000'],

            'home_primary_button_text' => ['nullable', 'string', 'max:100'],
            'home_secondary_button_text' => ['nullable', 'string', 'max:100'],
            'home_third_button_text' => ['nullable', 'string', 'max:100'],

            'home_hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'home_how_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'home_lab_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],

            'home_how_title' => ['nullable', 'string', 'max:255'],
            'home_how_description' => ['nullable', 'string', 'max:3000'],
            'home_lab_title' => ['nullable', 'string', 'max:255'],
            'home_lab_description' => ['nullable', 'string', 'max:3000'],
        ]);

        $data = [
            'site_name' => $validated['site_name'] ?? $siteSetting->site_name,
            'site_tagline' => $validated['site_tagline'] ?? $siteSetting->site_tagline,
            'footer_disclaimer' => $validated['footer_disclaimer'] ?? $siteSetting->footer_disclaimer,
            'payment_methods' => $this->preparePaymentMethods($request, $siteSetting),

            'home_hero_badge' => $validated['home_hero_badge'] ?? null,
            'home_hero_title' => $validated['home_hero_title'] ?? null,
            'home_hero_highlight' => $validated['home_hero_highlight'] ?? null,
            'home_hero_description' => $validated['home_hero_description'] ?? null,

            'home_primary_button_text' => $validated['home_primary_button_text'] ?? null,
            'home_secondary_button_text' => $validated['home_secondary_button_text'] ?? null,
            'home_third_button_text' => $validated['home_third_button_text'] ?? null,

            'home_how_title' => $validated['home_how_title'] ?? null,
            'home_how_description' => $validated['home_how_description'] ?? null,
            'home_lab_title' => $validated['home_lab_title'] ?? null,
            'home_lab_description' => $validated['home_lab_description'] ?? null,
        ];

        $fileFields = [
            'site_logo' => 'settings',
            'favicon' => 'settings',
            'home_hero_image' => 'home',
            'home_how_image' => 'home',
            'home_lab_image' => 'home',
        ];

        foreach ($fileFields as $field => $folder) {
            if ($request->hasFile($field)) {
                $oldPath = $siteSetting->{$field} ?? null;

                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }

                $data[$field] = $request->file($field)->store($folder, 'public');
            }
        }

        // Sirf existing DB columns update honge, unknown column error nahi aayega.
        $columns = Schema::getColumnListing('site_settings');
        $data = array_intersect_key($data, array_flip($columns));

        $siteSetting->update($data);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }

    private function preparePaymentMethods(Request $request, SiteSetting $siteSetting): array
    {
        $currentQrImages = collect($siteSetting->payment_methods ?? [])
            ->pluck('qr_image')
            ->filter()
            ->values()
            ->all();

        $methods = [];

        foreach ($request->input('payment_methods', []) as $index => $method) {
            $label = trim($method['label'] ?? '');
            $type = $method['type'] ?? 'upi';
            $upiId = trim($method['upi_id'] ?? '');
            $paymentLink = trim($method['payment_link'] ?? '');
            $instructions = trim($method['instructions'] ?? '');
            $existingQrImage = $method['existing_qr_image'] ?? null;

            $hasAnyValue = $label || $upiId || $paymentLink || $instructions || $existingQrImage || $request->hasFile("payment_methods.{$index}.qr_image");

            if (!$hasAnyValue) {
                continue;
            }

            if ($request->hasFile("payment_methods.{$index}.qr_image")) {
                $qrImage = $request
                    ->file("payment_methods.{$index}.qr_image")
                    ->store('payment-methods', 'public');

                if ($existingQrImage && Storage::disk('public')->exists($existingQrImage)) {
                    Storage::disk('public')->delete($existingQrImage);
                }
            } else {
                $qrImage = $existingQrImage;
            }

            $methods[] = [
                'label' => $label,
                'type' => in_array($type, ['upi', 'link'], true) ? $type : 'upi',
                'upi_id' => $upiId,
                'payment_link' => $paymentLink,
                'instructions' => $instructions,
                'qr_image' => $qrImage,
                'is_active' => $request->boolean("payment_methods.{$index}.is_active"),
            ];
        }

        $keptQrImages = collect($methods)->pluck('qr_image')->filter()->values()->all();

        foreach (array_diff($currentQrImages, $keptQrImages) as $removedQrImage) {
            if (Storage::disk('public')->exists($removedQrImage)) {
                Storage::disk('public')->delete($removedQrImage);
            }
        }

        return $methods;
    }
}
