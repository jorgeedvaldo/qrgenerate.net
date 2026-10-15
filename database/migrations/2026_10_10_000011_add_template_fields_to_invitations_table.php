<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            // "Sr. e Sra. Belmiro Cuna / Rosália Cuna" — shown above the names.
            $table->string('partner_one_parents')->nullable()->after('partner_two_name');
            $table->string('partner_two_parents')->nullable()->after('partner_one_parents');

            // The swatch circles under the dress code.
            $table->json('dress_code_colors')->nullable()->after('dress_code_notes');
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['partner_one_parents', 'partner_two_parents', 'dress_code_colors']);
        });
    }
};
