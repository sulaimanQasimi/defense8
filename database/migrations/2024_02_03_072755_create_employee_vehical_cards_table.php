<?php

use App\Models\Card\CardInfo;
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
        Schema::create('employee_vehical_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CardInfo::class)->nullable();
            $table->string("vehical_type")->nullable();
            $table->string("vehical_colour")->nullable();
            $table->string("vehical_palete")->nullable(); 
            $table->string("vehical_chassis")->nullable();
            $table->string("vehical_model")->nullable();
            $table->string("vehical_owner")->nullable();
            $table->string("vehical_engine_no")->nullable();
            $table->string("vehical_registration_no")->nullable();
            
            $table->string("name")->nullable();
            $table->string("last_name")->nullable();
            $table->string("father_name")->nullable();
            $table->string("grand_father_name")->nullable();
            $table->string("registare_no")->nullable();
            $table->string("national_id")->nullable();
            $table->string("phone")->nullable();
            $table->date("birthday")->nullable();
            
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_vehical_cards');
    }
};
