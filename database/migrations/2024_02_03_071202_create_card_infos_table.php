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
        Schema::create('card_infos', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();
            $table->string("last_name")->nullable();
            $table->string("father_name")->nullable();
            $table->string("grand_father_name")->nullable();
            $table->string("degree")->nullable();
            $table->string("grade")->nullable();
            $table->string("photo")->nullable();
            $table->string("acupation")->nullable();
            $table->string("registare_no")->nullable();
            $table->string("national_id")->nullable();
            $table->string("phone")->nullable();
            $table->date("birthday")->nullable();

            $table->string("job_structure")->nullable();
            $table->string("previous_job")->nullable();
            $table->string("department")->nullable();
            $table->string("m_village")->nullable();
            $table->string("m_district")->nullable();
            $table->string("m_province")->nullable();

            $table->string("c_village")->nullable();
            $table->string("c_district")->nullable();
            $table->string("c_province")->nullable();
            $table->text("remark")->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_infos');
    }
};
