<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Invitation extends Model
{
    use HasFactory;

    public const TYPES = ['wedding', 'engagement'];

    public const TEMPLATES = ['classic', 'botanical', 'modern', 'romantic'];

    public const FONTS = ['cormorant', 'playfair', 'lora', 'montserrat'];

    protected $fillable = [
        'user_id', 'slug', 'type', 'template',
        'partner_one_name', 'partner_two_name', 'display_title', 'tagline',
        'story', 'welcome_message',
        'event_date', 'event_time',
        'cover_url', 'couple_photo_url',
        'primary_color', 'accent_color', 'font',
        'dress_code', 'dress_code_notes', 'hashtag', 'music_url',
        'gift_message', 'pix_key', 'pix_name', 'bank_details',
        'rsvp_enabled', 'rsvp_deadline', 'allow_companions', 'max_companions',
        'guestbook_enabled', 'countdown_enabled',
        'contact_phone', 'contact_whatsapp', 'contact_email',
        'is_active',
    ];

    protected $casts = [
        'event_date'        => 'date',
        'rsvp_deadline'     => 'date',
        'rsvp_enabled'      => 'boolean',
        'allow_companions'  => 'boolean',
        'guestbook_enabled' => 'boolean',
        'countdown_enabled' => 'boolean',
        'is_active'         => 'boolean',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(InvitationEvent::class)->orderBy('sort_order');
    }

    public function guests(): HasMany
    {
        return $this->hasMany(InvitationGuest::class)->orderBy('name');
    }

    public function rsvps(): HasMany
    {
        return $this->hasMany(InvitationRsvp::class)->latest();
    }

    public function gifts(): HasMany
    {
        return $this->hasMany(InvitationGift::class)->orderBy('sort_order');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(InvitationPhoto::class)->orderBy('sort_order');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(InvitationMessage::class)->where('is_approved', true)->latest();
    }

    // ── Slug ────────────────────────────────────────────────────────────────

    public static function generateUniqueSlug(string $one, ?string $two = null): string
    {
        $base = Str::slug(trim($one . ' ' . ($two ? 'e ' . $two : '')));
        if (! $base) {
            $base = 'convite';
        }

        $slug = $base;
        $i = 2;
        while (static::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    // ── Presentation ────────────────────────────────────────────────────────

    public function coupleNames(): string
    {
        if ($this->display_title) {
            return $this->display_title;
        }

        return $this->partner_two_name
            ? "{$this->partner_one_name} & {$this->partner_two_name}"
            : $this->partner_one_name;
    }

    /** Date and time of the celebration as a single instant, for the countdown. */
    public function startsAt(): Carbon
    {
        $date = $this->event_date instanceof Carbon
            ? $this->event_date->copy()
            : Carbon::parse($this->event_date);

        if ($this->event_time) {
            [$h, $m] = array_pad(explode(':', (string) $this->event_time), 2, 0);

            return $date->setTime((int) $h, (int) $m);
        }

        return $date->startOfDay();
    }

    public function isPast(): bool
    {
        return $this->startsAt()->isPast();
    }

    public function rsvpOpen(): bool
    {
        if (! $this->rsvp_enabled) {
            return false;
        }

        if ($this->rsvp_deadline) {
            return ! $this->rsvp_deadline->endOfDay()->isPast();
        }

        return ! $this->startsAt()->endOfDay()->isPast();
    }

    // ── URLs ────────────────────────────────────────────────────────────────

    public function publicUrl(?string $guestCode = null): string
    {
        $url = url("/convite/{$this->slug}");

        return $guestCode ? $url . '?c=' . urlencode($guestCode) : $url;
    }

    public function manageUrl(): string
    {
        return route('invitations.edit', $this->slug);
    }

    // ── Aggregates ──────────────────────────────────────────────────────────

    public function confirmedCount(): int
    {
        return (int) $this->rsvps()->where('attending', true)->sum('companions')
            + (int) $this->rsvps()->where('attending', true)->count();
    }

    public function declinedCount(): int
    {
        return $this->rsvps()->where('attending', false)->count();
    }
}
