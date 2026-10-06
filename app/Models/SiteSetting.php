<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'site_tagline',
        'site_logo',
        'favicon',
        'footer_disclaimer',
        'payment_methods',

        'home_hero_badge',
        'home_hero_title',
        'home_hero_highlight',
        'home_hero_description',
        'home_primary_button_text',
        'home_secondary_button_text',
        'home_third_button_text',
        'home_hero_image',
        'home_how_image',
        'home_lab_image',
        'home_how_title',
        'home_how_description',
        'home_lab_title',
        'home_lab_description',
    ];

    protected $casts = [
        'payment_methods' => 'array',
    ];

    public static function current(): self
    {
        return self::query()->firstOrCreate(
            ['id' => 1],
            [
                'site_name' => 'COAVerify™',
                'site_tagline' => 'Batch Purity Verification',
                'footer_disclaimer' => 'COAVerify™ facilitates independent third-party analytical verification through partner laboratory networks.',
            ]
        );
    }

    public function activePaymentMethods(): array
    {
        return collect($this->payment_methods ?? [])
            ->filter(fn ($method) => !empty($method['label']) && !empty($method['is_active']))
            ->values()
            ->all();
    }

    public function paymentMethodsForAmount(float $amount = 0, ?string $currency = null): array
    {
        return collect($this->activePaymentMethods())
            ->map(function ($method) use ($amount, $currency) {
                $upiId = trim($method['upi_id'] ?? '');

                if ($upiId !== '') {
                    $upiParams = [
                        'pa' => $upiId,
                        'pn' => $method['label'] ?? 'Payment',
                    ];

                    if ($amount > 0 && strtoupper((string) $currency) === 'INR') {
                        $upiParams['am'] = number_format($amount, 2, '.', '');
                        $upiParams['cu'] = 'INR';
                    }

                    $upiLink = 'upi://pay?' . http_build_query($upiParams);
                    $qrSvg = QrCode::format('svg')
                        ->size(180)
                        ->margin(1)
                        ->generate($upiLink);

                    $method['generated_payment_link'] = $upiLink;
                    $method['generated_qr_base64'] = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);
                }

                return $method;
            })
            ->values()
            ->all();
    }
}
