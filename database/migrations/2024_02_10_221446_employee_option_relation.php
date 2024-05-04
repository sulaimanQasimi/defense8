<?php

use App\Models\Card\CardInfo;
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
        Schema::create('employee_option_related', function (Blueprint $table) {
            $table->foreignIdFor(CardInfo::class);
            $table->foreignIdFor(GuestOption::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
