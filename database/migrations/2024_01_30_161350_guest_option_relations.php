<?php

use App\Models\Guest;
use App\Models\GuestOption;
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
        Schema::create('guest_option_related', function (Blueprint $table) {
            $table->foreignIdFor(Guest::class);
            $table->foreignIdFor(GuestOption::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_option_related');
    }
};
