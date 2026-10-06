<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>COAVerify Certificate - {{ $report->batch_number }}</title>

    <style>
        @page {
            margin: 0;
            size: 1200px 680px;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            width: 1200px;
            height: 680px;
            background: #000000;
            color: #ffffff;
            font-family: DejaVu Sans, Arial, sans-serif;
            overflow: hidden;
        }

        * {
            box-sizing: border-box;
        }

        .certificate-page {
            width: 1200px;
            height: 680px;
            background: #000000;
            position: relative;
            overflow: hidden;
        }

        /*
         * Page: 1200 x 680
         * Label: 900 x 400
         * Equal margin approx:
         * Left/Right: 150px
         * Top/Bottom: 140px
        */
        .label-box {
            width: 600px;
            height: 500px;
            margin: 140px auto 0;
            border: 4px solid #f01818;
            border-radius: 7px;
            background: #000000;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

.curve-shadow {
    position: absolute;
    left: -86px;
    top: 32px;
    width: 750px;
    height: 116px;
    border-top: 5px solid rgba(88, 88, 88, 0.82);
    border-radius: 50% 50% 0 0;
    opacity: 0.65;
}

.curve-main {
    position: absolute;
    left: -80px;
    top: 20px;
    width: 750px;
    height: 112px;
    border-top: 6px solid rgba(245, 245, 245, 0.98);
    border-radius: 50% 50% 0 0;
    opacity: 0.98;
    box-shadow: 0 -2px 10px rgba(255, 255, 255, 0.08);
}

.curve-main::after {
    content: "";
    position: absolute;
    left: 18px;
    top: -7px;
    width: calc(100% - 36px);
    height: 98px;
    border-top: 2px solid rgba(255, 255, 255, 0.22);
    border-radius: 50% 50% 0 0;
}

        .content {
            position: relative;
            z-index: 2;
            padding: 14px 44px 8px;
            text-align: center;
        }

        .cert-logo {
            display: block;
            margin: 0 auto 5px;
            max-width: 145px;
            max-height: 92px;
            object-fit: contain;
        }

        .symbol {
            font-size: 30px;
            line-height: 30px;
            color: #ffffff;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .brand {
            margin-top: 10px;
            font-family: Georgia, "Times New Roman", DejaVu Serif, serif;
            font-size: 20px;
            line-height: 24px;
            font-weight: bold;
            color: #ffffff;
            letter-spacing: 1.4px;
            text-transform: uppercase;
        }

        .product {
            margin-top: 13px;
            font-family: Georgia, "Times New Roman", DejaVu Serif, serif;
            font-size: 40px;
            line-height: 58px;
            color: #ffffff;
            font-weight: bold;
            letter-spacing: 8px;
            text-transform: uppercase;
        }

        .strength {
            margin-top: 5px;
            font-size: 31px;
            line-height: 35px;
            font-weight: 400;
            color: #ffffff;
        }

        .divider {
            width: 320px;
            height: 13px;
            margin: 8px auto 5px;
            position: relative;
            text-align: center;
        }

        .divider:before,
        .divider:after {
            content: "";
            position: absolute;
            top: 6px;
            width: 140px;
            height: 1.5px;
            background: #ffffff;
        }

        .divider:before {
            left: 0;
        }

        .divider:after {
            right: 0;
        }

        .diamond {
            display: inline-block;
            width: 7px;
            height: 7px;
            background: #ffffff;
            transform: rotate(45deg);
            margin: 3px 3px 0;
        }

        .blend-title {
            margin-top: 3px;
            font-size: 17px;
            line-height: 21px;
            color: #ffffff;
            font-weight: 400;
            letter-spacing: 0.7px;
        }

        .blend-breakdown {
            margin-top: 2px;
            font-size: 16px;
            line-height: 20px;
            color: #ffffff;
            font-weight: 400;
            letter-spacing: 0.7px;
        }

        .usage {
            margin-top: 8px;
            font-size: 16px;
            line-height: 20px;
            color: #ffffff;
            font-weight: 400;
            letter-spacing: 1.3px;
        }

        .bottom-row {
            margin-top: 11px;
            font-size: 22px;
            line-height: 28px;
            color: #ffffff;
            letter-spacing: 2px;
            white-space: nowrap;
        }

        .bottom-row .bold {
            font-weight: bold;
        }

        .bottom-row .normal {
            font-weight: 400;
        }

        .pipe {
            display: inline-block;
            padding: 0 24px;
            font-weight: 400;
        }
    </style>
</head>

<body>
@php
    $siteSetting = \App\Models\SiteSetting::current();

    $logoBase64 = null;

    if ($siteSetting && $siteSetting->site_logo) {
        $logoPath = storage_path('app/public/' . $siteSetting->site_logo);

        if (file_exists($logoPath)) {
            $extension = strtolower(pathinfo($logoPath, PATHINFO_EXTENSION));

            if ($extension === 'png') {
                $mime = 'image/png';
            } elseif ($extension === 'webp') {
                $mime = 'image/webp';
            } else {
                $mime = 'image/jpeg';
            }

            $logoBase64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($logoPath));
        }
    }

    $brandName = $report->report_brand_name ?: strtoupper($report->client_company_name);
    $productName = strtoupper($report->product_name);
    $strength = $report->strength ?: '';
    $blendTitle = $report->blend_title ?: 'Verified Peptide Sample';

    if ($report->blend_breakdown) {
        $blendBreakdown = $report->blend_breakdown;
    } elseif (!is_null($report->purity_percent)) {
        $blendBreakdown = 'Purity Verified: ' . number_format((float) $report->purity_percent, 2) . '%';
    } else {
        $blendBreakdown = 'Purity Verified';
    }

    $usageText = $report->usage_text ?: 'For Research Use Only';
    $expiry = $report->expiry_label ?: 'N/A';
@endphp

<div class="certificate-page">
    <div class="label-box">
        <div class="curve-shadow"></div>
        <div class="curve-main"></div>

        <div class="content">
            @if($logoBase64)
                <img src="{{ $logoBase64 }}" class="cert-logo" alt="Logo">
            @else
                <div class="symbol">⚕</div>
            @endif

            <div class="brand">
                {{ $brandName }}
            </div>

            <div class="product">
                {{ $productName }}
            </div>

            <div class="strength">
                {{ $strength }}
            </div>

            <div class="divider">
                <span class="diamond"></span>
                <span class="diamond"></span>
                <span class="diamond"></span>
            </div>

            <div class="blend-title">
                {{ $blendTitle }}
            </div>

            <div class="blend-breakdown">
                {{ $blendBreakdown }}
            </div>

            <div class="usage">
                {{ $usageText }}
            </div>

            <div class="bottom-row">
                <span class="bold">Batch:</span>
                <span class="normal">{{ $report->batch_number }}</span>

                <span class="pipe">|</span>

                <span class="bold">Exp:</span>
                <span class="normal">{{ $expiry }}</span>
            </div>
        </div>
    </div>
</div>

</body>
</html>
