<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_gifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('store_url', 500)->nullable();
            $table->boolean('is_reserved')->default(false);
            $table->string('reserved_by')->nullable();
            $table->timestamp('reserved_at')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_gifts');
    }
};
