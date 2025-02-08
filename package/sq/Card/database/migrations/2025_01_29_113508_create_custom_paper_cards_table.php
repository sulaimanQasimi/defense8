<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Sq\Employee\Models\Department;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('custom_paper_cards', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->longText("details")->nullable();
            $table->json("attr")->nullable();
            $table->ipAddress()->nullable();

            $table->foreignIdFor(Department::class)->nullable();
            $table->string('type')->nullable();

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
        Schema::dropIfExists('custom_paper_cards');
    }
};
