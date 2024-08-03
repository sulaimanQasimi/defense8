<?php

use Sq\Employee\Models\CardInfo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Ramsey\Uuid\v1;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('main_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CardInfo::class)->nullable();
            $table->string("card_type")->nullable();
            $table->string("card_no")->nullable();
            $table->date("card_perform")->nullable();
            $table->date("card_expired_date")->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_cards');
    }
};
