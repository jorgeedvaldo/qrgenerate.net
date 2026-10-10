<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_rsvps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('invitation_guest_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone', 30)->nullable();
            $table->boolean('attending')->default(true);
            $table->unsignedTinyInteger('companions')->default(0);
            $table->text('companion_names')->nullable();
            $table->text('message')->nullable();
            $table->string('ip_hash', 64)->nullable();
            $table->timestamps();

            $table->index(['invitation_id', 'attending']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_rsvps');
    }
};
