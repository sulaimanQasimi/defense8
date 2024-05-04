<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('gun_cards', function (Blueprint $table) {
            $table->string('range')->nullable()->after('gun_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gun_cards', function (Blueprint $table) {
            $table->dropColumn('range');
        });
    }
};
