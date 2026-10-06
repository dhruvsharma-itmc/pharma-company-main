<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use App\Models\ServiceItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'title' => 'Peptides',
                'slug' => 'peptides',
                'badge' => 'Popular',
                'subtitle' => 'Purity verification for research peptide samples.',
                'description' => 'Submit peptide samples for COAVerify™ purity-focused verification review and secure batch authentication.',
                'sort_order' => 1,
                'items' => [
                    'Semaglutide Verification',
                    'Tirzepatide Verification',
                    'Retatrutide Verification',
                    'BPC-157 Verification',
                    'Ipamorelin Verification',
                    'AOD-9604 Verification',
                    'HGH Fragment Verification',
                    'Custom Peptide Sample Review',
                ],
            ],
            [
                'title' => 'Anabolic Steroids',
                'slug' => 'anabolic-steroids',
                'badge' => 'Category',
                'subtitle' => 'Sample verification category for authenticity and purity-focused reporting.',
                'description' => 'A clean category page for submitted anabolic steroid samples requiring COAVerify™ verification workflow.',
                'sort_order' => 2,
                'items' => [
                    'Oral Sample Verification',
                    'Oil-Based Sample Verification',
                    'Raw Material Sample Verification',
                    'Methyltestosterone Sample Review',
                    'Epistane Sample Review',
                    'DHT Ester Sample Review',
                    'Blind Screening Request',
                    'Identity-Only Sample Review',
                ],
            ],
            [
                'title' => 'SARMs & Related Compounds',
                'slug' => 'sarms-related-compounds',
                'badge' => 'Review',
                'subtitle' => 'Verification workflow for submitted SARMs and related compound samples.',
                'description' => 'Designed for clear sample submission, batch tracking, and purity-only COAVerify™ report display.',
                'sort_order' => 3,
                'items' => [
                    'RAD Sample Verification',
                    'LGD Sample Verification',
                    'GW Sample Verification',
                    'MK Sample Verification',
                    'SR Sample Verification',
                    'YK Sample Verification',
                    'Blind SARMs Screening Request',
                    'Custom SARMs Sample Review',
                ],
            ],
            [
                'title' => 'SERMs & Related Compounds',
                'slug' => 'serms-related-compounds',
                'badge' => 'Review',
                'subtitle' => 'Sample verification category for selected research compounds.',
                'description' => 'A simple verification category for client-submitted SERM samples and related compounds.',
                'sort_order' => 4,
                'items' => [
                    'Clomiphene Sample Review',
                    'Enclomiphene Sample Review',
                    'Raloxifene Sample Review',
                    'Tamoxifen Sample Review',
                    'Custom SERM Sample Review',
                ],
            ],
            [
                'title' => 'Sexual Health Ingredients',
                'slug' => 'sexual-health-ingredients',
                'badge' => 'Ingredient',
                'subtitle' => 'Verification category for submitted pharmaceutical ingredient samples.',
                'description' => 'Structured sample submission for product identity and purity-focused verification workflow.',
                'sort_order' => 5,
                'items' => [
                    'Sildenafil Sample Review',
                    'Tadalafil Sample Review',
                    'Vardenafil Sample Review',
                    'Avanafil Sample Review',
                    'Dapoxetine Sample Review',
                    'Blend Sample Review',
                ],
            ],
            [
                'title' => 'Harm Reduction Screening',
                'slug' => 'harm-reduction-screening',
                'badge' => 'Safety',
                'subtitle' => 'Verification support for contamination-focused review requests.',
                'description' => 'Used for submitted samples where clients require additional review before COAVerify™ report processing.',
                'sort_order' => 6,
                'items' => [
                    'Heavy Metals Screening Request',
                    'Contamination Screening Request',
                    'Endotoxin Review Request',
                    'Sterility Review Request',
                    'General Safety Review',
                ],
            ],
            [
                'title' => 'Other Samples',
                'slug' => 'other-samples',
                'badge' => 'Custom',
                'subtitle' => 'Custom sample review for products not listed in standard categories.',
                'description' => 'If the sample category is not listed, clients can submit the product details and our team can review the request.',
                'sort_order' => 7,
                'items' => [
                    'NMN Sample Review',
                    'L-Carnitine Sample Review',
                    'Custom Compound Review',
                    'Unknown Sample Request',
                    'Client-Specific Verification Request',
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $items = $categoryData['items'];
            unset($categoryData['items']);

            $category = ServiceCategory::updateOrCreate(
                ['slug' => $categoryData['slug']],
                [
                    ...$categoryData,
                    'meta_title' => $categoryData['title'] . ' - COAVerify™ Sample Verification',
                    'meta_description' => $categoryData['description'],
                    'is_active' => true,
                ]
            );

            foreach ($items as $index => $itemTitle) {
                ServiceItem::updateOrCreate(
                    [
                        'service_category_id' => $category->id,
                        'title' => $itemTitle,
                    ],
                    [
                        'slug' => Str::slug($itemTitle),
                        'short_description' => 'Submit sample details for COAVerify™ review and batch verification workflow.',
                        'price_label' => 'Request Review',
                        'sort_order' => $index + 1,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}