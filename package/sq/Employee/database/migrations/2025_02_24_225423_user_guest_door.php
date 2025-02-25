<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Sq\Employee\Models\Gate;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_guest_door', function (Blueprint $table) {
            $table->foreignIdFor(User::class)->nullable();
            $table->foreignIdFor(Gate::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('card_infos', function (Blueprint $table) {
            //
        });
    }
};
