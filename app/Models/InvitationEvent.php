<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvitationEvent extends Model
{
    public const KINDS = ['ceremony', 'reception', 'party', 'other'];

    protected $fillable = [
        'invitation_id', 'kind', 'title', 'venue_name', 'address',
        'maps_url', 'event_date', 'event_time', 'notes', 'sort_order',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

/**
     * Store times as H:i:s whatever the form sends, so the value does not
     * depend on how the database driver normalises a TIME column.
     */
    protected function eventTime(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => filled($value) ? substr($value, 0, 5) . ':00' : null,
        );
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    /** Google Maps link — the owner's own URL when given, otherwise derived from the address. */
    public function mapsLink(): ?string
    {
        if ($this->maps_url) {
            return $this->maps_url;
        }

        if ($this->address) {
            return 'https://www.google.com/maps/search/?api=1&query=' . urlencode($this->address);
        }

        return null;
    }
}
