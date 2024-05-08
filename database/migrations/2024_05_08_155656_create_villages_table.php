<?php

use App\Models\District;
use App\Models\Province;
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
        Schema::create('villages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Province::class)->constrained((new Province)->getTable())->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(District::class)->constrained((new District)->getTable())->cascadeOnDelete()->cascadeOnUpdate();
            $table->string("name")->nullable()->unique();
            $table->string("code")->nullable()->unique();
            $table->softDeletes();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('villages');
    }
};
