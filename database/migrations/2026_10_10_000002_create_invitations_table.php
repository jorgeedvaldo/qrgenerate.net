<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('slug')->unique();

            // wedding | engagement (birthday reserved for a later release)
            $table->string('type', 20)->default('wedding');
            $table->string('template', 30)->default('lilas');

            // Who is celebrating
            $table->string('partner_one_name');
            $table->string('partner_two_name')->nullable();
            $table->string('display_title')->nullable();
            $table->string('tagline')->nullable();
            $table->text('story')->nullable();
            $table->text('welcome_message')->nullable();

            // Main date — drives the countdown
            $table->date('event_date');
            $table->time('event_time')->nullable();

            // Imagery
            $table->string('cover_url')->nullable();
            $table->string('couple_photo_url')->nullable();

            // Theme
            $table->string('primary_color', 7)->default('#b08968');
            $table->string('accent_color', 7)->default('#7f5539');
            $table->string('font', 40)->default('cormorant');

            // Extras
            $table->string('dress_code')->nullable();
            $table->text('dress_code_notes')->nullable();
            $table->string('hashtag', 80)->nullable();
            $table->string('music_url')->nullable();

            // Gifts
            $table->text('gift_message')->nullable();
            $table->string('pix_key')->nullable();
            $table->string('pix_name')->nullable();
            $table->text('bank_details')->nullable();

            // RSVP behaviour
            $table->boolean('rsvp_enabled')->default(true);
            $table->date('rsvp_deadline')->nullable();
            $table->boolean('allow_companions')->default(true);
            $table->unsignedTinyInteger('max_companions')->default(2);
            $table->boolean('guestbook_enabled')->default(true);
            $table->boolean('countdown_enabled')->default(true);

            // Contact
            $table->string('contact_phone', 30)->nullable();
            $table->string('contact_whatsapp', 30)->nullable();
            $table->string('contact_email')->nullable();

            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('view_count')->default(0);
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
