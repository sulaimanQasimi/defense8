<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Sq\Guest\Models\Host;
use Sq\Employee\Models\Gate;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->nullable();
            $table->foreignIdFor(Host::class)->nullable();
            $table->foreignIdFor(Gate::class)->nullable();
            $table->string('name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('address')->nullable();
            $table->string('vehical_type')->nullable();
            $table->string('vehical_color')->nullable();
            $table->string('gender')->nullable();
            $table->string('status')->nullable();
            $table->string('blood_type')->nullable();
            $table->string('diseases')->nullable();
            $table->string('doctor_name')->nullable();
            $table->string('department')->nullable();
            $table->string('remark')->nullable();
            $table->dateTime('registered_at')->nullable();
            $table->integer('year')->nullable();
            $table->integer('day')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};