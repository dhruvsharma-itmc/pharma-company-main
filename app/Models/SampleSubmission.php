<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SampleSubmission extends Model
{
    protected $fillable = [
        'company_name',
        'contact_name',
        'email',
        'phone',
        'product_name',
        'batch_number',
        'strength',
        'notes',
        'sample_label_image',
        'coa_file',
        'payment_method_label',
        'payment_method_type',
        'payment_amount',
        'payment_currency',
        'payment_reference',
        'payment_proof_file',
        'cart_snapshot',
        'status',
    ];

    protected $casts = [
        'payment_amount' => 'decimal:2',
        'cart_snapshot' => 'array',
    ];

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'new' => 'New',
            'under_review' => 'Under Review',
            'verified' => 'Verified',
            'rejected' => 'Rejected',
            default => ucfirst(str_replace('_', ' ', $this->status)),
        };
    }
}
