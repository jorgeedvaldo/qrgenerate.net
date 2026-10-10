<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvitationRsvp extends Model
{
    protected $fillable = [
        'invitation_id', 'invitation_guest_id', 'name', 'email', 'phone',
        'attending', 'companions', 'companion_names', 'message', 'song_request', 'ip_hash',
    ];

    protected $casts = [
        'attending' => 'boolean',
    ];

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(InvitationGuest::class, 'invitation_guest_id');
    }

    /** The guest plus their companions. */
    public function partySize(): int
    {
        return $this->attending ? 1 + (int) $this->companions : 0;
    }
}
