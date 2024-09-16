<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::table('districts', function (Blueprint $table) {
            $table->string("name")->nullable()->change();

            $table->unique(["province_id",'name','deleted_at']);
        });
        Schema::table('villages', function (Blueprint $table) {
            $table->string("name")->nullable()->change();
            
            $table->unique(["district_id",'name','deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('location', function (Blueprint $table) {
            //
        });
    }
};
