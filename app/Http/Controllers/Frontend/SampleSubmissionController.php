<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SampleSubmission;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SampleSubmissionController extends Controller
{
    public function create()
    {
        $cart = session()->get('cart', [
            'items' => [],
            'subtotal' => 0,
            'currency' => 'USD',
        ]);
        $siteSetting = SiteSetting::current();
        $paymentMethods = $siteSetting->paymentMethodsForAmount(
            (float) ($cart['subtotal'] ?? 0),
            $cart['currency'] ?? null
        );

        return view('frontend.submit-sample', compact('paymentMethods', 'cart'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', [
            'items' => [],
            'subtotal' => 0,
            'currency' => 'USD',
        ]);
        $cartSubtotal = (float) ($cart['subtotal'] ?? 0);
        $siteSetting = SiteSetting::current();
        $paymentMethods = $siteSetting->paymentMethodsForAmount($cartSubtotal, $cart['currency'] ?? null);

        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],

            'product_name' => ['required', 'string', 'max:255'],
            'batch_number' => ['nullable', 'string', 'max:100'],
            'strength' => ['nullable', 'string', 'max:100'],

            'notes' => ['nullable', 'string', 'max:3000'],

            'sample_label_image' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,webp',
                'max:10240'
            ],

            'coa_file' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png,webp',
                'max:10240'
            ],

            'payment_method_key' => ['nullable', 'integer'],
            'payment_reference' => ['nullable', 'string', 'max:255'],
            'payment_proof_file' => [
                $cartSubtotal > 0 && !empty($paymentMethods) ? 'required' : 'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png,webp',
                'max:10240'
            ],
        ]);

        $selectedPaymentMethod = null;

        if ($cartSubtotal > 0 && !empty($paymentMethods)) {
            $paymentMethodKey = $validated['payment_method_key'] ?? null;

            if ($paymentMethodKey === null || !isset($paymentMethods[$paymentMethodKey])) {
                return back()
                    ->withErrors(['payment_method_key' => 'Please select a payment method.'])
                    ->withInput();
            }

            $selectedPaymentMethod = $paymentMethods[$paymentMethodKey];
        } elseif (isset($validated['payment_method_key']) && isset($paymentMethods[$validated['payment_method_key']])) {
            $selectedPaymentMethod = $paymentMethods[$validated['payment_method_key']];
        }

        $sampleLabelPath = null;
        $coaFilePath = null;
        $paymentProofPath = null;

        if ($request->hasFile('sample_label_image')) {
            $sampleLabelPath = $request
                ->file('sample_label_image')
                ->store('sample-submissions/labels', 'public');
        }

        if ($request->hasFile('coa_file')) {
            $coaFilePath = $request
                ->file('coa_file')
                ->store('sample-submissions/coa-files', 'public');
        }

        if ($request->hasFile('payment_proof_file')) {
            $paymentProofPath = $request
                ->file('payment_proof_file')
                ->store('sample-submissions/payment-proofs', 'public');
        }

        $submission = SampleSubmission::create([
            'company_name' => $validated['company_name'],
            'contact_name' => $validated['contact_name'] ?? null,
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,

            'product_name' => $validated['product_name'],
            'batch_number' => $validated['batch_number'] ?? null,
            'strength' => $validated['strength'] ?? null,

            'notes' => $validated['notes'] ?? null,

            'sample_label_image' => $sampleLabelPath,
            'coa_file' => $coaFilePath,
            'payment_method_label' => $selectedPaymentMethod['label'] ?? null,
            'payment_method_type' => $selectedPaymentMethod['type'] ?? null,
            'payment_amount' => $cartSubtotal > 0 ? $cartSubtotal : null,
            'payment_currency' => $cart['currency'] ?? null,
            'payment_reference' => $validated['payment_reference'] ?? null,
            'payment_proof_file' => $paymentProofPath,
            'cart_snapshot' => !empty($cart['items']) ? $cart : null,

            'status' => 'new',
        ]);

        session()->forget('cart');
        session(['customer_email' => strtolower(trim($submission->email))]);

        return redirect()
            ->route('user.submissions.show', $submission)
            ->with('success', 'Your sample details have been submitted successfully. Our verification team will review the information and contact you if required.');
    }
}
