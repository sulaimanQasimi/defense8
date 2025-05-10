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
        $permission = Permission::where('name', 'printed-card-view')->first();

        if (!$permission) {
            Permission::create([
                'name' => 'printed-card-view',
                'fa_name' => 'مشاهده گزارش کارت‌های چاپ شده',
                'group' => 'کارت',
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
        Permission::where('name', 'printed-card-view')->delete();
    }
};
