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
        Schema::create('biometric_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('record_id')->unique()->comment('ID of the related record');
            $table->string('Manufacturer')->nullable();
            $table->string('Model')->nullable();
            $table->string('SerialNumber')->nullable();
            $table->integer('ImageWidth')->nullable();
            $table->integer('ImageHeight')->nullable();
            $table->integer('ImageDPI')->nullable();
            $table->integer('ImageQuality')->nullable();
            $table->integer('NFIQ')->nullable();
            $table->longText('ImageDataBase64')->nullable();
            $table->longText('BMPBase64')->nullable();
            $table->longText('ISOTemplateBase64')->nullable();
            $table->longText('TemplateBase64')->nullable();
            $table->timestamps();

            $table->index('record_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biometric_data');
    }
};
