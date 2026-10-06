<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CoaReport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class VerifyController extends Controller
{
    public function index()
    {
        return view('frontend.verify', [
            'searched' => false,
            'batchNumber' => null,
            'report' => null,
        ]);
    }

    public function check(Request $request)
    {
        $validated = $request->validate([
            'batch_number' => ['required', 'string', 'max:100'],
        ]);

        $batchNumber = strtoupper(trim($validated['batch_number']));

        $report = CoaReport::query()
            ->whereRaw('UPPER(batch_number) = ?', [$batchNumber])
            ->first();

        return view('frontend.verify', [
            'searched' => true,
            'batchNumber' => $batchNumber,
            'report' => $report,
        ]);
    }

    public function downloadReport(CoaReport $report)
    {
        if ($report->status !== 'verified') {
            abort(404);
        }

        $verificationDate = $report->verification_date
            ? Carbon::parse($report->verification_date)
            : now();

        $taskNumber = '#' . str_pad($report->id + 26000, 5, '0', STR_PAD_LEFT);

        $uniqueId = 'CV-' . strtoupper($report->batch_number) . '-' . str_pad($report->id, 4, '0', STR_PAD_LEFT) . '-A1';

        $verifyLink = route('verify.index') . '?batch_number=' . urlencode($report->batch_number) . '&uid=' . urlencode($uniqueId);

        $qrSvg = QrCode::format('svg')
            ->size(160)
            ->margin(1)
            ->generate($verifyLink);

        $qrCodeBase64 = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);

        $pdf = Pdf::loadView('frontend.reports.coa-verification-report', [
            'report' => $report,
            'verificationDate' => $verificationDate,
            'taskNumber' => $taskNumber,
            'uniqueId' => $uniqueId,
            'verifyLink' => $verifyLink,
            'qrSvg' => $qrSvg,
            'qrCodeBase64' => $qrCodeBase64,
        ]);

        $pdf->setPaper([0, 0, 900, 1280]);

        return $pdf->download('COAVerify-' . $report->batch_number . '-Report.pdf');
    }
}