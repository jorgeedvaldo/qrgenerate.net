<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvitationScheduleItem extends Model
{
    protected $fillable = ['invitation_id', 'time', 'title', 'description', 'sort_order'];

    /** Store times as H:i:s whatever the form sends. */
    protected function time(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => filled($value) ? substr($value, 0, 5) . ':00' : null,
        );
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }
}
