<?php

namespace Database\Seeders;

use App\Models\CoaReport;
use Illuminate\Database\Seeder;

class CoaReportSeeder extends Seeder
{
    public function run(): void
    {
        CoaReport::updateOrCreate(
            ['batch_number' => 'EP0861'],
            [
                'product_name' => 'RETATRUTIDE',
                'strength' => '30mg',
                'purity_percent' => 99.70,
                'blend_title' => null,
                'blend_breakdown' => null,
                'usage_text' => 'For Research Use Only',
                'client_company_name' => 'Elite Pharm USA',
                'report_brand_name' => 'ELITE PHARM USA',
                'verification_date' => '2026-04-09',
                'expiry_label' => '4/28',
                'status' => 'verified',
                'notes' => 'COAVerify purity verification record.',
            ]
        );

        CoaReport::updateOrCreate(
            ['batch_number' => 'EP0862'],
            [
                'product_name' => 'KLOW',
                'strength' => '80mg',
                'purity_percent' => 99.20,
                'blend_title' => 'Proprietary Peptide Blend',
                'blend_breakdown' => '80mg Total (10+10+50+10)',
                'usage_text' => 'For Research Use Only',
                'client_company_name' => 'Elite Pharm USA',
                'report_brand_name' => 'ELITE PHARM USA',
                'verification_date' => '2026-04-09',
                'expiry_label' => '4/28',
                'status' => 'verified',
                'notes' => 'COAVerify purity verification record.',
            ]
        );
    }
}