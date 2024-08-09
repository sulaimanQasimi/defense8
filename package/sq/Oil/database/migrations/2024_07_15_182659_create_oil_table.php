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
        Schema::create('oil', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('oil_type')->nullable();
            $table->integer('oil_amount')->nullable();

            $table->string('oil_quality')->nullable();
            $table->date('filled_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oil');
    }
};
