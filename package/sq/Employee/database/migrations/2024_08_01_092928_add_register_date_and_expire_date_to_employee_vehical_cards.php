<?php

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
        Schema::table('employee_vehical_cards', function (Blueprint $table) {
            $table->date('register_date')->nullable();
            $table->date('expire_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_vehical_cards', function (Blueprint $table) {
            $table->dropColumn('register_date');
            $table->dropColumn('expire_date');
        });
    }
};
