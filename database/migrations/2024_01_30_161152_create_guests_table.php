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
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->nullable();
            $table->foreignIdFor(\App\Models\Host::class)->nullable();
            $table->foreignIdFor(\App\Models\Gate::class)->nullable();
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('career')->nullable();
            $table->longText('options')->nullable();

            $table->string('enter_gate')->nullable();
            
            $table->dateTime('registered_at')->nullable();
            
            $table->date('enter_at')->nullable();
            $table->date('exit_at')->nullable();
            $table->longText('person')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('host_id')
                ->on('hosts')
                ->references('id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('gate_id')
                ->on('gates')
                ->references('id')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
