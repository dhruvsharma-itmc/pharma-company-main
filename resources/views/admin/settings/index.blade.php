@extends('admin.layouts.app')

@section('title', 'Settings - COAVerify™')
@section('page_title', 'Website Settings')
@section('page_subtitle', 'Manage website branding, homepage hero section, and homepage images.')
@php
    $siteSetting = $siteSetting ?? $setting ?? \App\Models\SiteSetting::current();
@endphp
@section('content')

<div class="panel">
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf

        <h2 style="margin:0 0 18px;color:#f7dc95;font-family:Georgia,'Times New Roman',serif;">
            Brand Settings
        </h2>

        <div class="form-grid">
            <div class="form-group">
                <label>Site Name</label>
                <input type="text" name="site_name" value="{{ old('site_name', $siteSetting->site_name) }}" placeholder="COAVerify™">
            </div>

            <div class="form-group">
                <label>Site Tagline</label>
                <input type="text" name="site_tagline" value="{{ old('site_tagline', $siteSetting->site_tagline) }}" placeholder="Batch Purity Verification">
            </div>

            <div class="form-group">
                <label>Logo</label>

                @if($siteSetting->site_logo)
                    <div style="margin-bottom:10px;">
                        <img
                            src="{{ asset('storage/' . $siteSetting->site_logo) }}"
                            alt="Logo"
                            style="max-width:180px;max-height:100px;border:1px solid rgba(215,181,109,.32);border-radius:14px;padding:8px;background:#000;"
                        >
                    </div>
                @endif

                <input type="file" name="site_logo" accept=".jpg,.jpeg,.png,.webp">
            </div>

            <div class="form-group">
                <label>Favicon</label>

                @if($siteSetting->favicon)
                    <div style="margin-bottom:10px;">
                        <img
                            src="{{ asset('storage/' . $siteSetting->favicon) }}"
                            alt="Favicon"
                            style="max-width:70px;max-height:70px;border:1px solid rgba(215,181,109,.32);border-radius:12px;padding:6px;background:#000;"
                        >
                    </div>
                @endif

                <input type="file" name="favicon" accept=".jpg,.jpeg,.png,.webp,.ico">
            </div>

            <div class="form-group full">
                <label>Footer Disclaimer</label>
                <textarea name="footer_disclaimer" rows="3">{{ old('footer_disclaimer', $siteSetting->footer_disclaimer) }}</textarea>
            </div>
        </div>

        <hr style="border:0;border-top:1px solid rgba(215,181,109,.22);margin:28px 0;">

        <h2 style="margin:0 0 18px;color:#f7dc95;font-family:Georgia,'Times New Roman',serif;">
            Payment Settings
        </h2>

        @php
            $paymentMethods = old('payment_methods', $siteSetting->payment_methods ?: []);

            if (empty($paymentMethods)) {
                $paymentMethods = [
                    [
                        'label' => '',
                        'type' => 'upi',
                        'upi_id' => '',
                        'payment_link' => '',
                        'instructions' => '',
                        'qr_image' => '',
                        'is_active' => true,
                    ],
                ];
            }
        @endphp

        <div id="paymentMethods" style="display:grid;gap:18px;">
            @foreach($paymentMethods as $index => $method)
                <div class="payment-method-row" style="border:1px solid rgba(215,181,109,.22);border-radius:18px;padding:18px;background:rgba(0,0,0,.20);">
                    <div style="display:flex;justify-content:space-between;gap:12px;align-items:center;margin-bottom:16px;">
                        <strong style="color:#fff;">Payment Method</strong>
                        <button type="button" class="btn btn-danger remove-payment-method">Remove</button>
                    </div>

                    <input type="hidden" name="payment_methods[{{ $index }}][existing_qr_image]" value="{{ $method['qr_image'] ?? $method['existing_qr_image'] ?? '' }}">

                    <div class="form-grid">
                        <div class="form-group">
                            <label>Display Name</label>
                            <input type="text" name="payment_methods[{{ $index }}][label]" value="{{ $method['label'] ?? '' }}" placeholder="Example: Primary UPI / Google Pay">
                        </div>

                        <div class="form-group">
                            <label>Payment Type</label>
                            <select name="payment_methods[{{ $index }}][type]">
                                <option value="upi" {{ ($method['type'] ?? 'upi') === 'upi' ? 'selected' : '' }}>UPI / QR</option>
                                <option value="link" {{ ($method['type'] ?? 'upi') === 'link' ? 'selected' : '' }}>Payment Link</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>UPI ID</label>
                            <input type="text" name="payment_methods[{{ $index }}][upi_id]" value="{{ $method['upi_id'] ?? '' }}" placeholder="name@bank">
                        </div>

                        <div class="form-group">
                            <label>Payment Link</label>
                            <input type="url" name="payment_methods[{{ $index }}][payment_link]" value="{{ $method['payment_link'] ?? '' }}" placeholder="https://...">
                        </div>

                        <div class="form-group">
                            <label>QR Image</label>

                            @if(!empty($method['qr_image']))
                                <div style="margin-bottom:10px;">
                                    <img
                                        src="{{ asset('storage/' . $method['qr_image']) }}"
                                        alt="Payment QR"
                                        style="max-width:130px;max-height:130px;border:1px solid rgba(215,181,109,.32);border-radius:14px;padding:8px;background:#fff;object-fit:contain;"
                                    >
                                </div>
                            @endif

                            <input type="file" name="payment_methods[{{ $index }}][qr_image]" accept=".jpg,.jpeg,.png,.webp">
                            <span class="help">Upload QR image. Allowed: JPG, PNG, WEBP. Max 4MB.</span>
                        </div>

                        <div class="form-group">
                            <label>Active</label>
                            <label style="display:flex;align-items:center;gap:10px;color:#fff;font-weight:700;margin-top:12px;">
                                <input
                                    type="checkbox"
                                    name="payment_methods[{{ $index }}][is_active]"
                                    value="1"
                                    style="width:auto;"
                                    {{ !empty($method['is_active']) ? 'checked' : '' }}
                                >
                                Show this option to customers
                            </label>
                        </div>

                        <div class="form-group full">
                            <label>Payment Instructions</label>
                            <textarea name="payment_methods[{{ $index }}][instructions]" rows="3" placeholder="Example: Please pay the exact cart total and upload screenshot.">{{ $method['instructions'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="form-actions" style="margin-top:16px;">
            <button type="button" class="btn btn-outline" id="addPaymentMethod">Add Payment Method</button>
        </div>

        <hr style="border:0;border-top:1px solid rgba(215,181,109,.22);margin:28px 0;">

        <h2 style="margin:0 0 18px;color:#f7dc95;font-family:Georgia,'Times New Roman',serif;">
            Homepage Hero Section
        </h2>

        <div class="form-grid">
            <div class="form-group">
                <label>Hero Badge</label>
                <input
                    type="text"
                    name="home_hero_badge"
                    value="{{ old('home_hero_badge', $siteSetting->home_hero_badge) }}"
                    placeholder="Third-Party Batch Verification"
                >
            </div>

            <div class="form-group">
                <label>Hero Highlight Word</label>
                <input
                    type="text"
                    name="home_hero_highlight"
                    value="{{ old('home_hero_highlight', $siteSetting->home_hero_highlight) }}"
                    placeholder="You Can Trust"
                >
            </div>

            <div class="form-group full">
                <label>Hero Main Title</label>
                <input
                    type="text"
                    name="home_hero_title"
                    value="{{ old('home_hero_title', $siteSetting->home_hero_title) }}"
                    placeholder="Independent COA Verification"
                >
            </div>

            <div class="form-group full">
                <label>Hero Description</label>
                <textarea name="home_hero_description" rows="4" placeholder="Write homepage hero description...">{{ old('home_hero_description', $siteSetting->home_hero_description) }}</textarea>
            </div>

            <div class="form-group">
                <label>Primary Button Text</label>
                <input
                    type="text"
                    name="home_primary_button_text"
                    value="{{ old('home_primary_button_text', $siteSetting->home_primary_button_text) }}"
                    placeholder="Verify a Batch"
                >
            </div>

            <div class="form-group">
                <label>Secondary Button Text</label>
                <input
                    type="text"
                    name="home_secondary_button_text"
                    value="{{ old('home_secondary_button_text', $siteSetting->home_secondary_button_text) }}"
                    placeholder="Test Your Sample"
                >
            </div>

            <div class="form-group">
                <label>Third Button Text</label>
                <input
                    type="text"
                    name="home_third_button_text"
                    value="{{ old('home_third_button_text', $siteSetting->home_third_button_text) }}"
                    placeholder="Submit Sample"
                >
            </div>

            <div class="form-group full">
                <label>Hero Report Image</label>

                @if($siteSetting->home_hero_image)
                    <div style="margin-bottom:12px;">
                        <img
                            src="{{ asset('storage/' . $siteSetting->home_hero_image) }}"
                            alt="Hero Image"
                            style="max-width:360px;max-height:220px;border:1px solid rgba(215,181,109,.32);border-radius:18px;padding:8px;background:#000;object-fit:contain;"
                        >
                    </div>
                @endif

                <input type="file" name="home_hero_image" accept=".jpg,.jpeg,.png,.webp">
                <span class="help">Recommended: hero-report.png style image, 1200x900 or similar.</span>
            </div>
        </div>

        <hr style="border:0;border-top:1px solid rgba(215,181,109,.22);margin:28px 0;">

        <h2 style="margin:0 0 18px;color:#f7dc95;font-family:Georgia,'Times New Roman',serif;">
            Homepage Images & Sections
        </h2>

        <div class="form-grid">
            <div class="form-group">
                <label>How It Works Title</label>
                <input
                    type="text"
                    name="home_how_title"
                    value="{{ old('home_how_title', $siteSetting->home_how_title) }}"
                    placeholder="How COAVerify™ Works"
                >
            </div>

            <div class="form-group">
                <label>Lab Section Title</label>
                <input
                    type="text"
                    name="home_lab_title"
                    value="{{ old('home_lab_title', $siteSetting->home_lab_title) }}"
                    placeholder="Built for Laboratory-Level Confidence"
                >
            </div>

            <div class="form-group full">
                <label>How It Works Description</label>
                <textarea name="home_how_description" rows="3">{{ old('home_how_description', $siteSetting->home_how_description) }}</textarea>
            </div>

            <div class="form-group full">
                <label>Lab Section Description</label>
                <textarea name="home_lab_description" rows="3">{{ old('home_lab_description', $siteSetting->home_lab_description) }}</textarea>
            </div>

            <div class="form-group">
                <label>How It Works Image</label>

                @if($siteSetting->home_how_image)
                    <div style="margin-bottom:12px;">
                        <img
                            src="{{ asset('storage/' . $siteSetting->home_how_image) }}"
                            alt="How It Works"
                            style="max-width:260px;max-height:160px;border:1px solid rgba(215,181,109,.32);border-radius:18px;padding:8px;background:#000;object-fit:contain;"
                        >
                    </div>
                @endif

                <input type="file" name="home_how_image" accept=".jpg,.jpeg,.png,.webp">
            </div>

            <div class="form-group">
                <label>Lab / Medicine Testing Image</label>

                @if($siteSetting->home_lab_image)
                    <div style="margin-bottom:12px;">
                        <img
                            src="{{ asset('storage/' . $siteSetting->home_lab_image) }}"
                            alt="Lab Testing"
                            style="max-width:260px;max-height:160px;border:1px solid rgba(215,181,109,.32);border-radius:18px;padding:8px;background:#000;object-fit:contain;"
                        >
                    </div>
                @endif

                <input type="file" name="home_lab_image" accept=".jpg,.jpeg,.png,.webp">
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Settings</button>
        </div>
    </form>
</div>

<template id="paymentMethodTemplate">
    <div class="payment-method-row" style="border:1px solid rgba(215,181,109,.22);border-radius:18px;padding:18px;background:rgba(0,0,0,.20);">
        <div style="display:flex;justify-content:space-between;gap:12px;align-items:center;margin-bottom:16px;">
            <strong style="color:#fff;">Payment Method</strong>
            <button type="button" class="btn btn-danger remove-payment-method">Remove</button>
        </div>

        <input type="hidden" name="payment_methods[__INDEX__][existing_qr_image]" value="">

        <div class="form-grid">
            <div class="form-group">
                <label>Display Name</label>
                <input type="text" name="payment_methods[__INDEX__][label]" placeholder="Example: Primary UPI / Google Pay">
            </div>

            <div class="form-group">
                <label>Payment Type</label>
                <select name="payment_methods[__INDEX__][type]">
                    <option value="upi" selected>UPI / QR</option>
                    <option value="link">Payment Link</option>
                </select>
            </div>

            <div class="form-group">
                <label>UPI ID</label>
                <input type="text" name="payment_methods[__INDEX__][upi_id]" placeholder="name@bank">
            </div>

            <div class="form-group">
                <label>Payment Link</label>
                <input type="url" name="payment_methods[__INDEX__][payment_link]" placeholder="https://...">
            </div>

            <div class="form-group">
                <label>QR Image</label>
                <input type="file" name="payment_methods[__INDEX__][qr_image]" accept=".jpg,.jpeg,.png,.webp">
                <span class="help">Upload QR image. Allowed: JPG, PNG, WEBP. Max 4MB.</span>
            </div>

            <div class="form-group">
                <label>Active</label>
                <label style="display:flex;align-items:center;gap:10px;color:#fff;font-weight:700;margin-top:12px;">
                    <input type="checkbox" name="payment_methods[__INDEX__][is_active]" value="1" style="width:auto;" checked>
                    Show this option to customers
                </label>
            </div>

            <div class="form-group full">
                <label>Payment Instructions</label>
                <textarea name="payment_methods[__INDEX__][instructions]" rows="3" placeholder="Example: Please pay the exact cart total and upload screenshot."></textarea>
            </div>
        </div>
    </div>
</template>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const list = document.getElementById('paymentMethods');
        const addButton = document.getElementById('addPaymentMethod');
        const template = document.getElementById('paymentMethodTemplate');

        if (!list || !addButton || !template) {
            return;
        }

        let nextIndex = list.querySelectorAll('.payment-method-row').length;

        addButton.addEventListener('click', function () {
            const html = template.innerHTML.replaceAll('__INDEX__', String(nextIndex));
            list.insertAdjacentHTML('beforeend', html);
            nextIndex += 1;
        });

        list.addEventListener('click', function (event) {
            if (!event.target.classList.contains('remove-payment-method')) {
                return;
            }

            const rows = list.querySelectorAll('.payment-method-row');

            if (rows.length === 1) {
                rows[0].querySelectorAll('input[type="text"], input[type="url"], input[type="hidden"], textarea').forEach(function (field) {
                    field.value = '';
                });

                rows[0].querySelectorAll('input[type="file"]').forEach(function (field) {
                    field.value = '';
                });

                rows[0].querySelectorAll('input[type="checkbox"]').forEach(function (field) {
                    field.checked = false;
                });

                return;
            }

            event.target.closest('.payment-method-row').remove();
        });
    });
</script>
@endpush
