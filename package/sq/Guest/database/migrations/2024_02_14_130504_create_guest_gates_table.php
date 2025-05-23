<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Sq\Employee\Models\Gate;
use Sq\Guest\Models\Guest;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guest_gates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Guest::class);
            $table->foreignIdFor(Gate::class);
            $table->dateTime('entered_at')->nullable();
            $table->dateTime('exit_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_gates');
    }
};
