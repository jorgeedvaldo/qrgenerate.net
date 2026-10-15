<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('message');
            $table->boolean('is_approved')->default(true);
            $table->string('ip_hash', 64)->nullable();
            $table->timestamps();

            $table->index(['invitation_id', 'is_approved']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_messages');
    }
};
