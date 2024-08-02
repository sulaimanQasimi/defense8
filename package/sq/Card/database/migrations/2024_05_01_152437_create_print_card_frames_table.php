<?php

use App\Support\Defense\Print\PrintTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('print_card_frames', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            // Logo Paths
            $table->string('gov_logo')->nullable();
            $table->string('ministry_logo')->nullable();
            $table->string('background_logo')->nullable();

            $table->double('gov_logo_x')->nullable();
            $table->double('gov_logo_y')->nullable();
            //
            $table->double('ministry_logo_x')->nullable();
            $table->double('ministry_logo_y')->nullable();


            $table->double('profile_logo_x')->nullable();
            $table->double('profile_logo_y')->nullable();

            $table->double('qr_code_logo_x')->nullable();
            $table->double('qr_code_logo_y')->nullable();

            $table->string('gov_name')->nullable();
            $table->double('gov_name_font_size')->nullable();


            $table->string('ministry_name')->nullable();
            $table->double('ministry_name_font_size')->nullable();

            $table->double('info_font_size')->nullable();
            $table->string('color')->nullable();
            $table->enum('type', [
                "ArmorCar",
                "Employee",
                "BlackMirrorCar",
                "EmployeeCar",
                "Gun",
            ])->nullable();
            // $table->morphs("pritable");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('print_card_frames');
    }
};
