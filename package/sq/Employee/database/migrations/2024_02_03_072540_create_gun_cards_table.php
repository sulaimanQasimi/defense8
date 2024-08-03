<?php

use Sq\Employee\Models\CardInfo;
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
        Schema::create('gun_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CardInfo::class)->nullable();
            $table->string("gun_type")->nullable();
            $table->string("gun_no")->nullable();
            $table->date("filled_form_date")->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gun_cards');
    }
};
