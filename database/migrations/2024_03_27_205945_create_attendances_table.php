<?php

use App\Models\Card\CardInfo;
use App\Models\Gate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CardInfo::class)->nullable();
            $table->foreignIdFor(Gate::class)->nullable();
            $table->date("date")->nullable();
            $table->dateTime("time")->nullable();
            $table->dateTime("enter")->nullable();
            $table->dateTime("exit")->nullable();
            $table->string("state")->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
