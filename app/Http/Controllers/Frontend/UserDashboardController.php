<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CoaReport;
use App\Models\SampleSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserDashboardController extends Controller
{
    public function showLogin()
    {
        if (session()->has('customer_email')) {
            return redirect()->route('user.dashboard');
        }

        return view('frontend.user-dashboard.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'batch_number' => ['nullable', 'string', 'max:100'],
        ]);

        if (empty($validated['phone']) && empty($validated['batch_number'])) {
            return back()
                ->withErrors(['phone' => 'Please enter phone number or batch number to access your dashboard.'])
                ->withInput();
        }

        $email = strtolower(trim($validated['email']));
        $phone = trim($validated['phone'] ?? '');
        $batchNumber = strtoupper(trim($validated['batch_number'] ?? ''));

        $submissionExists = SampleSubmission::query()
            ->whereRaw('LOWER(email) = ?', [$email])
            ->where(function ($query) use ($phone, $batchNumber) {
                if ($phone !== '') {
                    $query->orWhere('phone', $phone);
                }

                if ($batchNumber !== '') {
                    $query->orWhereRaw('UPPER(batch_number) = ?', [$batchNumber]);
                }
            })
            ->exists();

        if (!$submissionExists) {
            return back()
                ->withErrors(['email' => 'No matching sample submission found for these details.'])
                ->withInput();
        }

        session([
            'customer_email' => $email,
        ]);

        return redirect()->route('user.dashboard');
    }

    public function index()
    {
        $email = session('customer_email');

        if (!$email) {
            return redirect()->route('user.login');
        }

        $submissions = SampleSubmission::query()
            ->whereRaw('LOWER(email) = ?', [strtolower($email)])
            ->latest()
            ->get();

        $reportsByBatch = CoaReport::query()
            ->whereIn('batch_number', $submissions->pluck('batch_number')->filter()->map(fn ($batch) => strtoupper($batch))->all())
            ->get()
            ->keyBy(fn ($report) => strtoupper($report->batch_number));

        $stats = [
            'total' => $submissions->count(),
            'under_review' => $submissions->where('status', 'under_review')->count(),
            'verified' => $submissions->where('status', 'verified')->count(),
            'payment_proofs' => $submissions->filter(fn ($submission) => !empty($submission->payment_proof_file))->count(),
        ];

        return view('frontend.user-dashboard.index', compact('submissions', 'reportsByBatch', 'stats'));
    }

    public function show(SampleSubmission $sampleSubmission)
    {
        $this->authorizeCustomerSubmission($sampleSubmission);

        $coaReport = null;

        if ($sampleSubmission->batch_number) {
            $coaReport = CoaReport::query()
                ->whereRaw('UPPER(batch_number) = ?', [strtoupper($sampleSubmission->batch_number)])
                ->first();
        }

        return view('frontend.user-dashboard.show', compact('sampleSubmission', 'coaReport'));
    }

    public function updatePaymentProof(Request $request, SampleSubmission $sampleSubmission)
    {
        $this->authorizeCustomerSubmission($sampleSubmission);

        $validated = $request->validate([
            'payment_reference' => ['nullable', 'string', 'max:255'],
            'payment_proof_file' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:10240'],
        ]);

        if ($sampleSubmission->payment_proof_file && Storage::disk('public')->exists($sampleSubmission->payment_proof_file)) {
            Storage::disk('public')->delete($sampleSubmission->payment_proof_file);
        }

        $paymentProofPath = $request
            ->file('payment_proof_file')
            ->store('sample-submissions/payment-proofs', 'public');

        $sampleSubmission->update([
            'payment_reference' => $validated['payment_reference'] ?? $sampleSubmission->payment_reference,
            'payment_proof_file' => $paymentProofPath,
        ]);

        return redirect()
            ->route('user.submissions.show', $sampleSubmission)
            ->with('success', 'Payment proof uploaded successfully.');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('customer_email');

        return redirect()
            ->route('user.login')
            ->with('success', 'You have been logged out.');
    }

    private function authorizeCustomerSubmission(SampleSubmission $sampleSubmission): void
    {
        $email = session('customer_email');

        if (!$email || strtolower($sampleSubmission->email) !== strtolower($email)) {
            abort(403);
        }
    }
}
