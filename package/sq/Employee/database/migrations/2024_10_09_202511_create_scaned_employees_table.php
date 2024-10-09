<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Sq\Employee\Models\CardInfo;
use Sq\Employee\Models\Gate;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(table: 'scaned_employees', callback: function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(model: CardInfo::class)->nullable();
            $table->foreignIdFor(model: Gate::class)->nullable();
            $table->dateTime(column: 'scaned_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scaned_employees');
    }
};
