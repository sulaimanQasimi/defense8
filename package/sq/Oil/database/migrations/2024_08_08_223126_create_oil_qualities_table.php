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
        Schema::create('oil_qualities', function (Blueprint $table) {
            $table->id();
            $table->string("oil_type")->nullable();
            $table->string("name")->nullable();
            $table->timestamps();
            $table->unique(["oil_type",'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oil_qualities');
    }
};
