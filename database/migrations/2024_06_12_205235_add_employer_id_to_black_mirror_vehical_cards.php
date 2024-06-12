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
        Schema::table('black_mirror_vehical_cards', function (Blueprint $table) {
            $table->foreignId("driver_id");
            $table->foreign('driver_id')->references('id')->on("card_infos")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('black_mirror_vehical_cards', function (Blueprint $table) {
            //
        });
    }
};
