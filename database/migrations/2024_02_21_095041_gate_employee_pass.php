<?php

use App\Models\Card\CardInfo;
use App\Models\Gate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cardinfo_gates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CardInfo::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Gate::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->dateTime('entered_at')->nullable();
            $table->dateTime('exit_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cardinfo_gates');
    }
};
