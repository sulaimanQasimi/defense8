<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class Update13 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::query()->whereIn('group',[__('Armor Vehical Card'),__('Black Mirror Vehical Card')])->delete();

        Permission::create(['name' =>"add remark for vehical", 'fa_name' => "افزودن ملاحظات برای وسایل کارمندان", 'group' => __("Employee Vehical Card")]);

    }
}
