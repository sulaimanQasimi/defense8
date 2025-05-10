<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pump_stations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location')->nullable();
            $table->text('address')->nullable();
            $table->string('contact_number')->nullable();
            $table->integer('capacity')->nullable()->comment('Capacity in liters');
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // Add pump_station_id to oil table
        Schema::table('oil', function (Blueprint $table) {
            $table->foreignId('pump_station_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });

        // Add pump_station_id to oil_disterbutions table
        Schema::table('oil_disterbutions', function (Blueprint $table) {
            $table->foreignId('pump_station_id')->nullable()->after('id')->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove foreign keys
        Schema::table('oil', function (Blueprint $table) {
            $table->dropForeign(['pump_station_id']);
            $table->dropColumn('pump_station_id');
        });

        Schema::table('oil_disterbutions', function (Blueprint $table) {
            $table->dropForeign(['pump_station_id']);
            $table->dropColumn('pump_station_id');
        });

        Schema::dropIfExists('pump_stations');
    }
};