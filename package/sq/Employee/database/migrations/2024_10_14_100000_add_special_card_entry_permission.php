<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permission = Permission::where('name', 'special-id-card')->first();

        if (!$permission) {
            Permission::create([
                'name' => 'special-id-card',
                'fa_name' => 'ثبت کارت ویژه برای کارمندان',
                'group' => 'مشخصات کارمند',
                'guard_name' => 'web'
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Permission::where('name', 'special-id-card')->delete();
    }
};
