<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Sq\Card\Models\PrintCardFrame;
use Sq\Employee\Models\CardInfo;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('print_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(model: CardInfo::class)->nullable();
            $table->foreignIdFor(model: User::class)->nullable();
            $table->foreignIdFor(model: PrintCardFrame::class)->nullable();
            $table->date(column: 'issue')->nullable();
            $table->date(column: 'expire')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('print_cards');
    }
};
