<?php

use App\Models\Card\CardInfo;
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
        Schema::create('oil_disterbutions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CardInfo::class)->nullable();
            $table->string("oil_type")->nullable();
            $table->integer("oil_amount")->nullable();
            $table->date("filled_date")->nullable();
            $table->timestamps();
            $table->foreign('card_info_id')->on("card_infos")->references('id')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oil_disterbutions');
    }
};
