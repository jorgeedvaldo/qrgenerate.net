<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuItem extends Model
{
    protected $fillable = [
        'menu_section_id', 'name', 'description', 'price',
        'image_url', 'is_available', 'is_featured', 'badges', 'sort_order',
    ];

    protected $casts = [
        'price'        => 'decimal:2',
        'is_available' => 'boolean',
        'is_featured'  => 'boolean',
        'badges'       => 'array',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(MenuSection::class, 'menu_section_id');
    }

    public function formattedPrice(): string
    {
        if ($this->price === null) {
            return '';
        }
        return 'R$ ' . number_format((float) $this->price, 2, ',', '.');
    }
}
