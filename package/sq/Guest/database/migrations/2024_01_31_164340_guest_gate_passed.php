<?php

use Sq\Guest\Models\Guest;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Sq\Employee\Models\Gate;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guest_gate_passed', function (Blueprint $table) {
            $table->foreignIdFor(Guest::class);
            $table->foreignIdFor(Gate::class);
            $table->dateTime('passed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_gate_passed');
    }
};
