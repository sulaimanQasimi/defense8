<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('card_infos', function (Blueprint $table) {

            $table->foreignId("m_village")->change()->nullable();
            $table->foreignId("m_district")->change()->nullable();
            $table->foreignId("m_province")->change()->nullable();

            $table->foreignId("c_village")->change()->nullable();
            $table->foreignId("c_district")->change()->nullable();
            $table->foreignId("c_province")->change()->nullable();

            $table->foreign("m_village")->references('id')->on('villages')->nullOnDelete();
            $table->foreign("m_district")->references('id')->on('districts')->nullOnDelete();
            $table->foreign("m_province")->references('id')->on('provinces')->nullOnDelete();

            $table->foreign("c_village")->references('id')->on('villages')->nullOnDelete();
            $table->foreign("c_district")->references('id')->on('districts')->nullOnDelete();
            $table->foreign("c_province")->references('id')->on('provinces')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('card_infos');
    }
};
