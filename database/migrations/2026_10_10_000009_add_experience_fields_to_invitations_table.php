<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            // Envelope intro: the sealed card a guest taps to open the invitation.
            $table->string('monogram', 12)->nullable()->after('hashtag');
            $table->boolean('envelope_enabled')->default(true)->after('monogram');
            $table->boolean('petals_enabled')->default(true)->after('envelope_enabled');
            $table->boolean('mascot_enabled')->default(true)->after('petals_enabled');

            // site = store the reply here; whatsapp = send it to the couple's
            // WhatsApp; both = offer the guest either.
            $table->string('rsvp_mode', 20)->default('site')->after('rsvp_enabled');
            $table->boolean('song_request_enabled')->default(true)->after('rsvp_mode');

            // "Manual do bom convidado" tips and ride-hailing deep links.
            $table->json('guest_tips')->nullable()->after('dress_code_notes');
            $table->json('ride_links')->nullable()->after('guest_tips');
        });

        Schema::table('invitation_rsvps', function (Blueprint $table) {
            $table->string('song_request')->nullable()->after('message');
        });
    }

    public function down(): void
    {
        Schema::table('invitation_rsvps', function (Blueprint $table) {
            $table->dropColumn('song_request');
        });

        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn([
                'monogram', 'envelope_enabled', 'petals_enabled', 'mascot_enabled',
                'rsvp_mode', 'song_request_enabled', 'guest_tips', 'ride_links',
            ]);
        });
    }
};
