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
            $table->string("oil_type")->nullable();
            $table->integer("daily_rate")->nullable();
            $table->integer("weekly_rate")->nullable();
            $table->integer("monthly_rate")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('card_infos', function (Blueprint $table) {
            $table->dropColumn("oil_type");
            $table->dropColumn("daily_rate");
            $table->dropColumn("weekly_rate");
            $table->dropColumn("monthly_rate");
        });
    }
};
