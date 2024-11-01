<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('main_cards', function (Blueprint $table) {
            $table->text('remark')->nullable();
            $table->foreignIdFor(User::class)->nullable();
            $table->boolean('printed')->default(false);
            $table->dateTime('printed_at')->nullable();
            $table->boolean('expired')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('main_cards', function (Blueprint $table) {
            $table->dropColumn('remark');
            $table->dropConstrainedForeignIdFor(User::class);
            $table->dropColumn('printed');
            $table->dropColumn('printed_at');
            $table->dropColumn('expired');
        });
    }
};
