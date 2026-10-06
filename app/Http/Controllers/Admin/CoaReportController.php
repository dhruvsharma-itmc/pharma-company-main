<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoaReport;
use App\Models\SampleSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CoaReportController extends Controller
{
    public function index(Request $request)
    {
        $reports = CoaReport::query()
            ->when($request->filled('q'), function ($query) use ($request) {
                $search = trim($request->q);

                $query->where(function ($q) use ($search) {
                    $q->where('batch_number', 'like', "%{$search}%")
                        ->orWhere('product_name', 'like', "%{$search}%")
                        ->orWhere('client_company_name', 'like', "%{$search}%")
                        ->orWhere('report_brand_name', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.coa-reports.index', compact('reports'));
    }

    public function create(Request $request)
    {
        $sourceSubmission = null;

        if ($request->filled('sample_submission_id')) {
            $sourceSubmission = SampleSubmission::query()->find($request->integer('sample_submission_id'));

            if ($sourceSubmission?->batch_number) {
                $existingReport = CoaReport::query()
                    ->whereRaw('UPPER(batch_number) = ?', [strtoupper($sourceSubmission->batch_number)])
                    ->first();

                if ($existingReport) {
                    return redirect()
                        ->route('admin.coa-reports.edit', $existingReport)
                        ->with('success', 'COA report already exists for this batch. You can edit it here.');
                }
            }
        }

        return view('admin.coa-reports.create', compact('sourceSubmission'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'batch_number' => ['required', 'string', 'max:100', 'unique:coa_reports,batch_number'],
            'product_name' => ['required', 'string', 'max:255'],
            'strength' => ['nullable', 'string', 'max:100'],
            'purity_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],

            'blend_title' => ['nullable', 'string', 'max:255'],
            'blend_breakdown' => ['nullable', 'string', 'max:255'],
            'usage_text' => ['nullable', 'string', 'max:255'],

            'client_company_name' => ['required', 'string', 'max:255'],
            'report_brand_name' => ['nullable', 'string', 'max:255'],

            'verification_date' => ['nullable', 'date'],
            'sample_received_date' => ['nullable', 'date'],
            'expiry_label' => ['nullable', 'string', 'max:100'],

            'status' => ['required', Rule::in(['verified', 'pending', 'revoked'])],

            'notes' => ['nullable', 'string', 'max:5000'],

            'report_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'sample_label_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'source_sample_submission_id' => ['nullable', 'integer', 'exists:sample_submissions,id'],
        ]);

        $reportPdfPath = null;
        $labelImagePath = null;
        $sourceSubmission = null;

        if (!empty($validated['source_sample_submission_id'])) {
            $sourceSubmission = SampleSubmission::query()->find($validated['source_sample_submission_id']);
        }

        if ($request->hasFile('report_pdf')) {
            $reportPdfPath = $request->file('report_pdf')->store('coa-reports/pdfs', 'public');
        }

        if ($request->hasFile('sample_label_image')) {
            $labelImagePath = $request->file('sample_label_image')->store('coa-reports/labels', 'public');
        } elseif ($sourceSubmission?->sample_label_image && Storage::disk('public')->exists($sourceSubmission->sample_label_image)) {
            $extension = pathinfo($sourceSubmission->sample_label_image, PATHINFO_EXTENSION) ?: 'jpg';
            $labelImagePath = 'coa-reports/labels/source-submission-' . $sourceSubmission->id . '-' . uniqid() . '.' . $extension;
            Storage::disk('public')->copy($sourceSubmission->sample_label_image, $labelImagePath);
        }

        $coaReport = CoaReport::create([
            'batch_number' => strtoupper(trim($validated['batch_number'])),
            'product_name' => $validated['product_name'],
            'strength' => $validated['strength'] ?? null,
            'purity_percent' => $validated['purity_percent'] ?? null,

            'blend_title' => $validated['blend_title'] ?? null,
            'blend_breakdown' => $validated['blend_breakdown'] ?? null,
            'usage_text' => $validated['usage_text'] ?? 'For Research Use Only',

            'client_company_name' => $validated['client_company_name'],
            'report_brand_name' => $validated['report_brand_name'] ?? $validated['client_company_name'],

            'verification_date' => $validated['verification_date'] ?? now()->toDateString(),
            'sample_received_date' => $validated['sample_received_date'] ?? null,
            'expiry_label' => $validated['expiry_label'] ?? null,

            'status' => $validated['status'],

            'report_pdf' => $reportPdfPath,
            'sample_label_image' => $labelImagePath,
            'notes' => $validated['notes'] ?? null,
        ]);

        if ($sourceSubmission) {
            $sourceSubmission->update(['status' => 'verified']);
        }

        return redirect()
            ->route('admin.coa-reports.edit', $coaReport)
            ->with('success', 'COA report created successfully.');
    }

    public function edit(CoaReport $coaReport)
    {
        return view('admin.coa-reports.edit', compact('coaReport'));
    }

    public function update(Request $request, CoaReport $coaReport)
    {
        $validated = $request->validate([
            'batch_number' => [
                'required',
                'string',
                'max:100',
                Rule::unique('coa_reports', 'batch_number')->ignore($coaReport->id),
            ],
            'product_name' => ['required', 'string', 'max:255'],
            'strength' => ['nullable', 'string', 'max:100'],
            'purity_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],

            'blend_title' => ['nullable', 'string', 'max:255'],
            'blend_breakdown' => ['nullable', 'string', 'max:255'],
            'usage_text' => ['nullable', 'string', 'max:255'],

            'client_company_name' => ['required', 'string', 'max:255'],
            'report_brand_name' => ['nullable', 'string', 'max:255'],

            'verification_date' => ['nullable', 'date'],
            'sample_received_date' => ['nullable', 'date'],
            'expiry_label' => ['nullable', 'string', 'max:100'],

            'status' => ['required', Rule::in(['verified', 'pending', 'revoked'])],

            'notes' => ['nullable', 'string', 'max:5000'],

            'report_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'sample_label_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ]);

        $reportPdfPath = $coaReport->report_pdf;
        $labelImagePath = $coaReport->sample_label_image;

        if ($request->hasFile('report_pdf')) {
            if ($reportPdfPath && Storage::disk('public')->exists($reportPdfPath)) {
                Storage::disk('public')->delete($reportPdfPath);
            }

            $reportPdfPath = $request->file('report_pdf')->store('coa-reports/pdfs', 'public');
        }

        if ($request->hasFile('sample_label_image')) {
            if ($labelImagePath && Storage::disk('public')->exists($labelImagePath)) {
                Storage::disk('public')->delete($labelImagePath);
            }

            $labelImagePath = $request->file('sample_label_image')->store('coa-reports/labels', 'public');
        }

        $coaReport->update([
            'batch_number' => strtoupper(trim($validated['batch_number'])),
            'product_name' => $validated['product_name'],
            'strength' => $validated['strength'] ?? null,
            'purity_percent' => $validated['purity_percent'] ?? null,

            'blend_title' => $validated['blend_title'] ?? null,
            'blend_breakdown' => $validated['blend_breakdown'] ?? null,
            'usage_text' => $validated['usage_text'] ?? 'For Research Use Only',

            'client_company_name' => $validated['client_company_name'],
            'report_brand_name' => $validated['report_brand_name'] ?? $validated['client_company_name'],

            'verification_date' => $validated['verification_date'] ?? null,
            'sample_received_date' => $validated['sample_received_date'] ?? null,
            'expiry_label' => $validated['expiry_label'] ?? null,

            'status' => $validated['status'],

            'report_pdf' => $reportPdfPath,
            'sample_label_image' => $labelImagePath,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('admin.coa-reports.index')
            ->with('success', 'COA report updated successfully.');
    }

    public function destroy(CoaReport $coaReport)
    {
        if ($coaReport->report_pdf && Storage::disk('public')->exists($coaReport->report_pdf)) {
            Storage::disk('public')->delete($coaReport->report_pdf);
        }

        if ($coaReport->sample_label_image && Storage::disk('public')->exists($coaReport->sample_label_image)) {
            Storage::disk('public')->delete($coaReport->sample_label_image);
        }

        $coaReport->delete();

        return redirect()
            ->route('admin.coa-reports.index')
            ->with('success', 'COA report deleted successfully.');
    }
}
