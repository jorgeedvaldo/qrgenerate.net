<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Menu extends Model
{
    protected $fillable = [
        'slug', 'edit_token', 'restaurant_name', 'description',
        'logo_url', 'cover_url', 'phone', 'address', 'website',
        'whatsapp', 'instagram', 'facebook',
        'contact_email', 'recovery_email',
        'primary_color', 'accent_color', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(MenuSection::class)->orderBy('sort_order');
    }

    public static function generateUniqueSlug(string $name): string
    {
        $base = Str::slug($name);
        if (!$base) {
            $base = 'cardapio';
        }

        $slug = $base;
        $i = 2;
        while (static::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    public function publicUrl(): string
    {
        return url("/menu/{$this->slug}");
    }

    public function editUrl(): string
    {
        return url("/menu/{$this->slug}/editar?token={$this->edit_token}");
    }
}
