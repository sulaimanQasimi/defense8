<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Permission::create([
            "name" => "Create Village",
            'guard' =>    'web',
            "fa_name" =>        "ایجاد قریه",
            'group' => "موقیعت"
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::where('name', 'Create Village')->forceDelete();
    }
};
