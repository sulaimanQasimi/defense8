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
        Schema::table('card_infos', function (Blueprint $table) {
            $table->foreignId('pump_station_id')->nullable()->after('department_id')->references('id')->on('pump_stations')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('card_infos', function (Blueprint $table) {
            $table->dropForeign(['pump_station_id']);
            $table->dropColumn('pump_station_id');
        });
    }
};
