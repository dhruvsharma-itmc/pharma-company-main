<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>COAVerify Report - {{ $report->batch_number }}</title>

    <style>
        @page {
            margin: 0;
            size: 900px 1280px;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 900px;
            height: 1180px;
            background: #050505;
            color: #ffffff;
            font-family: DejaVu Sans, Arial, sans-serif;
            overflow: hidden;
        }

        * {
            box-sizing: border-box;
        }

        .page {
            width: 900px;
            height: 1180px;
            background: #050505;
            padding: 34px 70px;
            overflow: hidden;
        }

        .report {
            width: 760px;
            height: 1090px;
            border: 3px solid #b8924d;
            background: #101010;
            position: relative;
            padding: 12px 18px 14px;
            overflow: hidden;
        }

        .report:before {
            content: "";
            position: absolute;
            top: 10px;
            left: 10px;
            right: 10px;
            bottom: 10px;
            border: 1px solid rgba(215,181,109,0.62);
        }

        .report:after {
            content: "";
            position: absolute;
            top: 18px;
            left: 18px;
            right: 18px;
            bottom: 18px;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .shine-top {
            position: absolute;
            top: 50px;
            left: 120px;
            width: 500px;
            height: 160px;
            background: rgba(215,181,109,0.045);
            border-radius: 50%;
        }

        .shine-mid {
            position: absolute;
            top: 410px;
            left: 150px;
            width: 430px;
            height: 150px;
            background: rgba(255,255,255,0.022);
            border-radius: 50%;
        }

        .shine-bottom {
            position: absolute;
            bottom: 120px;
            left: 140px;
            width: 470px;
            height: 130px;
            background: rgba(215,181,109,0.03);
            border-radius: 50%;
        }

        .content {
            position: relative;
            z-index: 2;
            width: 100%;
        }

        .logo-row {
            text-align: center;
            padding-top: 0;
            margin-top: -18px;
            margin-bottom: 0;
            line-height: 0;
        }

        .logo-center {
            text-align: center;
            line-height: 0;
        }

        .logo-img {
            max-width: 440px;
            max-height: 318px;
            display: inline-block;
            object-fit: contain;
        }

        .logo-symbol {
            width: 92px;
            height: 92px;
            border: 4px solid #d7b56d;
            border-radius: 20px;
            color: #d7b56d;
            font-size: 48px;
            line-height: 80px;
            display: inline-block;
            text-align: center;
            font-weight: bold;
        }

        .title-line {
            margin: -2px auto 5px;
            width: 610px;
            position: relative;
            text-align: center;
        }

        .title-line:before,
        .title-line:after {
            content: "";
            position: absolute;
            top: 17px;
            width: 54px;
            height: 1px;
            background: #b8924d;
        }

        .title-line:before {
            left: 0;
        }

        .title-line:after {
            right: 0;
        }

        .title-line h1 {
            margin: 0;
            color: #f6d58b;
            font-family: Georgia, "Times New Roman", DejaVu Serif, serif;
            font-size: 28px;
            letter-spacing: 1.4px;
            font-weight: bold;
            line-height: 32px;
        }

        .divider {
            width: 690px;
            margin: 7px auto;
            height: 5px;
            font-size: 0;
            line-height: 0;
            text-align: center;
        }

        .divider table {
            width: 690px;
            border-collapse: collapse;
            margin: 0 auto;
        }

        .divider td {
            padding: 0;
            vertical-align: middle;
        }

        .divider-left,
        .divider-right {
            width: 315px;
            height: 1px;
            background: #8b6a34;
        }

        .divider-center {
            width: 60px;
            height: 3px;
            background: #d6b15f;
        }

        .top-info {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 4px;
            margin-left: 20px;
        }

        .top-info td {
            padding: 6px 0;
            color: #f0d7a1;
            font-size: 17px;
            vertical-align: top;
            word-wrap: break-word;
        }

        .top-info .value {
            color: #ffffff;
            font-size: 17px;
            padding-left: 8px;
        }

        .details {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
            table-layout: fixed;
            margin-left: 20px;
        }

        .details td {
            padding: 6px 0;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            font-size: 18px;
            word-wrap: break-word;
        }

        .details td:first-child {
            width: 155px;
            color: #f0d7a1;
        }

        .details td:last-child {
            color: #ffffff;
            padding-left: 12px;
        }

        .section-label {
            margin-top: 12px;
            color: #f0d7a1;
            font-size: 19px;
            margin-left: 20px;
        }

        .section-text {
            color: #ffffff;
            font-size: 17px;
            line-height: 1.35;
            margin-top: 6px;
            margin-left: 20px;
        }

        .result-box {
            margin-top: 8px;
            border: 2px solid #b8924d;
            height: 88px;
            display: table;
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            background: rgba(255,255,255,0.012);
        }

        .result-product,
        .result-purity,
        .result-qr {
            display: table-cell;
            vertical-align: middle;
            border-right: 1px solid rgba(184,146,77,0.55);
        }

        .result-product {
            width: 45%;
            padding: 10px 14px;
            color: #ffffff;
        }

        .result-product strong {
            display: block;
            font-size: 23px;
            line-height: 1.2;
            font-weight: normal;
        }

        .result-product span {
            display: block;
            margin-top: 4px;
            font-size: 21px;
            color: #ffffff;
        }

        .result-purity {
            width: 27%;
            text-align: center;
            color: #f6d58b;
            font-size: 41px;
            font-weight: bold;
        }

        .result-qr {
            width: 28%;
            border-right: 0;
            text-align: center;
        }

        .qr-box {
            display: inline-block;
            width: 78px;
            height: 78px;
            background: #ffffff;
            padding: 4px;
            border: 1px solid #ffffff;
            overflow: hidden;
        }

        .qr-img {
            display: block;
            width: 68px;
            height: 68px;
            object-fit: contain;
        }

        .qr-box svg {
            width: 68px;
            height: 68px;
            display: block;
        }

        .qr-fallback {
            display: inline-block;
            width: 68px;
            height: 68px;
            background: #ffffff;
            color: #000000;
            font-size: 13px;
            line-height: 68px;
            text-align: center;
            font-weight: bold;
        }

        .analysis-row {
            margin-top: 9px;
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-left: 20px;
        }

        .analysis-row td {
            font-size: 17px;
            color: #f0d7a1;
            padding: 4px 0;
            vertical-align: middle;
        }

        .analysis-row td:first-child {
            width: 58%;
        }

        .analysis-row td:last-child {
            width: 42%;
        }

        .analysis-row .signature {
            text-align: right;
            color: #ffffff;
            white-space: nowrap;
            padding-right: 6px;
        }

        .signature-label {
            display: inline-block;
            color: #ffffff;
            font-size: 16px;
            vertical-align: middle;
            margin-right: 1px;
        }

        .signature-box {
            display: inline-block;
            width: 145px;
            height: 62px;
            vertical-align: middle;
            text-align: right;
            overflow: hidden;
        }

        .signature-img {
            display: inline-block;
            max-width: 140px;
            max-height: 60px;
            width: auto;
            height: auto;
            object-fit: contain;
        }

        .signature-fallback {
            color: #f6d58b;
            font-family: Georgia, "Times New Roman", DejaVu Serif, serif;
            font-size: 22px;
            font-style: italic;
        }

        .verify-section {
            margin-top: 8px;
            border-top: 1px solid #6b5530;
            padding-top: 8px;
            text-align: center;
        }

        .verify-text {
            color: #ffffff;
            font-size: 15px;
            letter-spacing: 0.3px;
            line-height: 1.35;
        }

        .verify-text strong {
            color: #f6d58b;
        }

        .unique-id {
            margin: 7px auto 0;
            width: 540px;
            border: 1px solid #b8924d;
            color: #ffffff;
            padding: 8px 14px;
            font-size: 21px;
            letter-spacing: 1.6px;
            text-align: center;
        }

        .footer-note {
            margin-top: 7px;
            text-align: center;
            color: rgba(255,255,255,0.52);
            font-size: 10px;
            line-height: 1.28;
            padding: 0 18px;
        }
    </style>
</head>

<body>
@php
    $logoBase64 = null;

    $makeImageBase64 = function (?string $path) {
        if (!$path || !file_exists($path)) {
            return null;
        }

        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if ($extension === 'png') {
            $mime = 'image/png';
        } elseif ($extension === 'webp') {
            $mime = 'image/webp';
        } else {
            $mime = 'image/jpeg';
        }

        return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path));
    };

    /*
     * Static logo path only.
     * Image file must be here:
     * public/storage/home/logo-report.png
     */
    $logoBase64 = $makeImageBase64(public_path('storage/home/logo-report.png'));

    $product = trim($report->product_name . ' ' . ($report->strength ?: ''));
    $batch = $report->batch_number;
    $client = $report->client_company_name ?: 'N/A';
    $purity = !is_null($report->purity_percent) ? number_format((float) $report->purity_percent, 1) . '%' : 'N/A';

    $verificationDate = isset($verificationDate)
        ? \Illuminate\Support\Carbon::parse($verificationDate)
        : ($report->verification_date ? \Illuminate\Support\Carbon::parse($report->verification_date) : now());

    $testingOrdered = $verificationDate->copy()->subDays(11)->format("d M 'y");
    $sampleReceived = $verificationDate->copy()->subDays(6)->format("d M 'y");
    $analysisDate = $verificationDate->format('d M Y');

    $taskNumber = $taskNumber ?? ('#' . str_pad($report->id + 26000, 5, '0', STR_PAD_LEFT));
    $uniqueId = $uniqueId ?? ('CV-' . strtoupper($batch) . '-' . str_pad($report->id, 4, '0', STR_PAD_LEFT) . '-A1');
    $verifyLink = $verifyLink ?? url('/verify');

    $signatureBase64 = null;
    $signatureFiles = glob(public_path('storage/signature/*.{png,jpg,jpeg,webp}'), GLOB_BRACE);

    if (!empty($signatureFiles)) {
        $signaturePath = $signatureFiles[0];
        $signatureExtension = strtolower(pathinfo($signaturePath, PATHINFO_EXTENSION));

        if ($signatureExtension === 'png') {
            $signatureMime = 'image/png';
        } elseif ($signatureExtension === 'webp') {
            $signatureMime = 'image/webp';
        } else {
            $signatureMime = 'image/jpeg';
        }

        $signatureBase64 = 'data:' . $signatureMime . ';base64,' . base64_encode(file_get_contents($signaturePath));
    }
@endphp

<div class="page">
    <div class="report">
        <div class="shine-top"></div>
        <div class="shine-mid"></div>
        <div class="shine-bottom"></div>

        <div class="content">

            <div class="logo-row">
                <div class="logo-center">
                    @if($logoBase64)
                        <img src="{{ $logoBase64 }}" class="logo-img" alt="Logo">
                    @else
                        <div class="logo-symbol">✓</div>
                    @endif
                </div>
            </div>

            <div class="title-line">
                <h1>COA VERIFICATION REPORT</h1>
            </div>

            <table class="top-info">
                <tr>
                    <td style="width:50%;">
                        Task Number
                        <span class="value">{{ $taskNumber }}</span>
                    </td>

                    <td style="width:50%;">
                        Testing ordered &gt;
                        <span class="value">{{ strtoupper($testingOrdered) }}</span>
                    </td>
                </tr>

                <tr>
                    <td></td>

                    <td>
                        Sample received &gt;
                        <span class="value">{{ strtoupper($sampleReceived) }}</span>
                    </td>
                </tr>
            </table>

            <div class="divider">
                <table>
                    <tr>
                        <td class="divider-left"></td>
                        <td class="divider-center"></td>
                        <td class="divider-right"></td>
                    </tr>
                </table>
            </div>

            <table class="details">
                <tr>
                    <td>Client</td>
                    <td>{{ $client }}</td>
                </tr>

                <tr>
                    <td>Sample</td>
                    <td>{{ $product }}</td>
                </tr>

                <tr>
                    <td>Batch</td>
                    <td>{{ $batch }}</td>
                </tr>
            </table>

            <div class="section-label">
                Tests requested &gt;
            </div>

            <div class="section-text">
                Purity assessment of {{ $report->product_name }}.
            </div>

            <div class="divider">
                <table>
                    <tr>
                        <td class="divider-left"></td>
                        <td class="divider-center"></td>
                        <td class="divider-right"></td>
                    </tr>
                </table>
            </div>

            <div class="section-label">
                Results &gt;
            </div>

            <div class="result-box">
                <div class="result-product">
                    <strong>{{ $report->product_name }}</strong>
                    <span>{{ $report->strength ?: '' }}</span>
                </div>

                <div class="result-purity">
                    {{ $purity }}
                </div>

                <div class="result-qr">
                    @if(!empty($qrCodeBase64))
                        <div class="qr-box">
                            <img src="{{ $qrCodeBase64 }}" alt="QR Code" class="qr-img">
                        </div>
                    @elseif(!empty($qrSvg))
                        <div class="qr-box">
                            {!! $qrSvg !!}
                        </div>
                    @else
                        <div class="qr-fallback">QR</div>
                    @endif
                </div>
            </div>

            <table class="analysis-row">
                <tr>
                    <td>
                        Analysis conducted &gt;
                        <span style="color:#ffffff;">{{ strtoupper($analysisDate) }}</span>
                    </td>

                    <td class="signature">
                        <span class="signature-label">Signature:</span>

                        <span class="signature-box">
                            @if($signatureBase64)
                                <img src="{{ $signatureBase64 }}" alt="Signature" class="signature-img">
                            @else
                                <span class="signature-fallback">CoAVerify</span>
                            @endif
                        </span>
                    </td>
                </tr>
            </table>

            <div class="verify-section">
                <div class="verify-text">
                    Verify this COA at <strong>{{ parse_url($verifyLink, PHP_URL_HOST) }}/verify</strong> with the unique ID:
                </div>

                <div class="unique-id">
                    {{ $uniqueId }}
                </div>
            </div>

            <div class="footer-note">
                COAVerify™ facilitates independent third-party analytical verification through partner laboratory networks.
                This report is generated for secure batch authentication and purity verification display.
            </div>

        </div>
    </div>
</div>

</body>
</html>