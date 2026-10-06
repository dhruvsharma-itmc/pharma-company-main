<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoaReport;
use App\Models\SampleSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SampleSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $submissions = SampleSubmission::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = trim($request->q);

                $query->where(function ($q) use ($search) {
                    $q->where('company_name', 'like', "%{$search}%")
                        ->orWhere('contact_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('product_name', 'like', "%{$search}%")
                        ->orWhere('batch_number', 'like', "%{$search}%")
                        ->orWhere('strength', 'like', "%{$search}%")
                        ->orWhere('payment_reference', 'like', "%{$search}%")
                        ->orWhere('payment_method_label', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.sample-submissions.index', compact('submissions'));
    }

    public function show(SampleSubmission $sampleSubmission)
    {
        $existingCoaReport = null;

        if ($sampleSubmission->batch_number) {
            $existingCoaReport = CoaReport::query()
                ->whereRaw('UPPER(batch_number) = ?', [strtoupper($sampleSubmission->batch_number)])
                ->first();
        }

        return view('admin.sample-submissions.show', compact('sampleSubmission', 'existingCoaReport'));
    }

    public function edit(SampleSubmission $sampleSubmission)
    {
        return view('admin.sample-submissions.edit', compact('sampleSubmission'));
    }

    public function update(Request $request, SampleSubmission $sampleSubmission)
    {
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'contact_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],

            'product_name' => ['required', 'string', 'max:255'],
            'batch_number' => ['nullable', 'string', 'max:100'],
            'strength' => ['nullable', 'string', 'max:100'],

            'notes' => ['nullable', 'string', 'max:3000'],

            'status' => [
                'required',
                Rule::in(['new', 'under_review', 'verified', 'rejected']),
            ],

            'sample_label_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],

            'coa_file' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png,webp',
                'max:10240',
            ],

            'payment_reference' => ['nullable', 'string', 'max:255'],

            'payment_proof_file' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png,webp',
                'max:10240',
            ],
        ]);

        $sampleLabelPath = $sampleSubmission->sample_label_image;
        $coaFilePath = $sampleSubmission->coa_file;
        $paymentProofPath = $sampleSubmission->payment_proof_file;

        if ($request->hasFile('sample_label_image')) {
            if ($sampleLabelPath && Storage::disk('public')->exists($sampleLabelPath)) {
                Storage::disk('public')->delete($sampleLabelPath);
            }

            $sampleLabelPath = $request->file('sample_label_image')
                ->store('sample-submissions/labels', 'public');
        }

        if ($request->hasFile('coa_file')) {
            if ($coaFilePath && Storage::disk('public')->exists($coaFilePath)) {
                Storage::disk('public')->delete($coaFilePath);
            }

            $coaFilePath = $request->file('coa_file')
                ->store('sample-submissions/coa-files', 'public');
        }

        if ($request->hasFile('payment_proof_file')) {
            if ($paymentProofPath && Storage::disk('public')->exists($paymentProofPath)) {
                Storage::disk('public')->delete($paymentProofPath);
            }

            $paymentProofPath = $request->file('payment_proof_file')
                ->store('sample-submissions/payment-proofs', 'public');
        }

        $sampleSubmission->update([
            'company_name' => $validated['company_name'],
            'contact_name' => $validated['contact_name'] ?? null,
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,

            'product_name' => $validated['product_name'],
            'batch_number' => $validated['batch_number'] ?? null,
            'strength' => $validated['strength'] ?? null,

            'notes' => $validated['notes'] ?? null,

            'status' => $validated['status'],

            'sample_label_image' => $sampleLabelPath,
            'coa_file' => $coaFilePath,
            'payment_reference' => $validated['payment_reference'] ?? null,
            'payment_proof_file' => $paymentProofPath,
        ]);

        return redirect()
            ->route('admin.sample-submissions.show', $sampleSubmission)
            ->with('success', 'Sample submission updated successfully.');
    }

    public function destroy(SampleSubmission $sampleSubmission)
    {
        if ($sampleSubmission->sample_label_image && Storage::disk('public')->exists($sampleSubmission->sample_label_image)) {
            Storage::disk('public')->delete($sampleSubmission->sample_label_image);
        }

        if ($sampleSubmission->coa_file && Storage::disk('public')->exists($sampleSubmission->coa_file)) {
            Storage::disk('public')->delete($sampleSubmission->coa_file);
        }

        if ($sampleSubmission->payment_proof_file && Storage::disk('public')->exists($sampleSubmission->payment_proof_file)) {
            Storage::disk('public')->delete($sampleSubmission->payment_proof_file);
        }

        $sampleSubmission->delete();

        return redirect()
            ->route('admin.sample-submissions.index')
            ->with('success', 'Sample submission deleted successfully.');
    }
}
