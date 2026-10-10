<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();

            // ceremony | reception | party | other
            $table->string('kind', 20)->default('ceremony');
            $table->string('title');
            $table->string('venue_name')->nullable();
            $table->string('address')->nullable();
            $table->string('maps_url', 500)->nullable();
            $table->date('event_date')->nullable();
            $table->time('event_time')->nullable();
            $table->text('notes')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_events');
    }
};
