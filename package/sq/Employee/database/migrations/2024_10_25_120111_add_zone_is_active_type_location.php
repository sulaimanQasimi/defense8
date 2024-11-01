<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Sq\Location\Models\District;
use Sq\Location\Models\Province;
use Sq\Query\Support\TashkeelType;
use Sq\Query\Support\ZoneEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
            $table->string('zone')->nullable();
            $table->string('code')->nullable()->unique();
            $table->integer('stracture_count')->nullable();
            $table->string('tashkeel_type')->nullable();
            $table->string(column: "start")->nullable()->change();
            $table->string(column: "end")->nullable()->change();

            $table->foreignIdFor(Province::class)->nullable();
            $table->foreignIdFor(District::class)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {

            $table->dropColumn('code');
            $table->dropColumn('is_active');
            $table->dropColumn('zone');
            $table->dropColumn('stracture_count');
            $table->dropColumn('tashkeel_type');

            $table->dropConstrainedForeignIdFor(Province::class);
            $table->dropConstrainedForeignIdFor(District::class);
        });
    }
};
