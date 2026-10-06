<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceCategory extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'badge',
        'subtitle',
        'description',
        'meta_title',
        'meta_description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(ServiceItem::class);
    }

    public function activeItems(): HasMany
    {
        return $this->hasMany(ServiceItem::class)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('title');
    }
}