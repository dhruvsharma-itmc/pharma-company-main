<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoaReport extends Model
{
    protected $fillable = [
        'batch_number',
        'product_name',
        'strength',
        'purity_percent',
        'blend_title',
        'blend_breakdown',
        'usage_text',
        'client_company_name',
        'report_brand_name',
        'verification_date',
        'sample_received_date',
        'expiry_label',
        'status',
        'report_pdf',
        'sample_label_image',
        'notes',
    ];

    protected $casts = [
        'verification_date' => 'date',
        'sample_received_date' => 'date',
        'purity_percent' => 'decimal:2',
    ];

    public function getDisplayProductAttribute(): string
    {
        return trim($this->product_name . ' ' . ($this->strength ?: ''));
    }
}
