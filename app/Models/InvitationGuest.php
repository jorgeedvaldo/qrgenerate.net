<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class InvitationGuest extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitation_id', 'name', 'code', 'email', 'phone',
        'group_label', 'max_companions', 'opened_at',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
    ];

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function rsvps(): HasMany
    {
        return $this->hasMany(InvitationRsvp::class);
    }

    /** A short, URL-safe code unique within the invitation. */
    public static function generateCode(int $invitationId, string $name): string
    {
        $base = Str::limit(Str::slug($name), 20, '');
        if (! $base) {
            $base = 'convidado';
        }

        $code = $base;
        $i = 2;
        while (static::where('invitation_id', $invitationId)->where('code', $code)->exists()) {
            $code = "{$base}-{$i}";
            $i++;
        }

        return $code;
    }

    public function hasResponded(): bool
    {
        return $this->rsvps()->exists();
    }
}
