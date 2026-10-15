<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * The first four templates were renamed when the ten-template set landed.
 * Invitations created before that still carry the old keys, so point them at
 * their closest match instead of silently falling back.
 */
return new class extends Migration
{
    private const RENAMED = [
        'classic'   => 'classico',
        'botanical' => 'botanico',
        'modern'    => 'moderno',
        'romantic'  => 'romantico',
    ];

    public function up(): void
    {
        foreach (self::RENAMED as $old => $new) {
            DB::table('invitations')->where('template', $old)->update(['template' => $new]);
        }

        // Databases migrated before the rename still default the column to a key
        // that no longer exists.
        Schema::table('invitations', function (Blueprint $table) {
            $table->string('template', 30)->default('lilas')->change();
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->string('template', 30)->default('classic')->change();
        });

        foreach (self::RENAMED as $old => $new) {
            DB::table('invitations')->where('template', $new)->update(['template' => $old]);
        }
    }
};
