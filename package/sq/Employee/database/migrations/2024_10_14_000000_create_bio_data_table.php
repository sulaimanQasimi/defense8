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
        Schema::create('bio_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personal_info_id')->constrained('card_infos')->onDelete('cascade');
            $table->string('Manufacturer')->nullable();
            $table->string('Model')->nullable();
            $table->string('SerialNumber')->nullable();
            $table->string('ImageWidth')->nullable();
            $table->string('ImageHeight')->nullable();
            $table->string('ImageDPI')->nullable();
            $table->string('ImageQuality')->nullable();
            $table->string('NFIQ')->nullable();
            $table->longText('ImageDataBase64')->nullable();
            $table->longText('BMPBase64')->nullable();
            $table->longText('ISOTemplateBase64')->nullable();
            $table->longText('TemplateBase64')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bio_data');
    }
};
