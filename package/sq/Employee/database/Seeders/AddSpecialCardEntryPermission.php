<?php

namespace Sq\Employee\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AddSpecialCardEntryPermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => "special-id-card", 'fa_name' => "ثبت کارت ویژه برای کارمندان", 'group' => "مشخصات کارمند"]);

    }
}
