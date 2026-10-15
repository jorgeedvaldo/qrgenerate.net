<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->string('name');

            // Short code used in the personalised link: /convite/{slug}?c={code}
            $table->string('code', 32);
            $table->string('email')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('group_label', 60)->nullable();
            $table->unsignedTinyInteger('max_companions')->default(0);
            $table->timestamp('opened_at')->nullable();
            $table->timestamps();

            $table->unique(['invitation_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_guests');
    }
};
