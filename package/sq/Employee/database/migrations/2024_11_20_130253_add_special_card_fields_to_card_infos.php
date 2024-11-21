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
        Schema::table('card_infos', function (Blueprint $table) {
            $table->string('special_gun',255)->nullable();
            $table->string('special_black_mirror',255)->nullable();
            $table->string('special_vehical',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('card_infos', function (Blueprint $table) {
            $table->dropColumn('special_gun');
            $table->dropColumn('special_black_mirror');
            $table->dropColumn('special_vehical');

        });
    }
};
