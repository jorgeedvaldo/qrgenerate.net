<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvitationGift extends Model
{
    protected $fillable = [
        'invitation_id', 'name', 'description', 'image_url', 'price',
        'store_url', 'is_reserved', 'reserved_by', 'reserved_at', 'sort_order',
    ];

    protected $casts = [
        'price'       => 'decimal:2',
        'is_reserved' => 'boolean',
        'reserved_at' => 'datetime',
    ];

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }
}
