<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class Update16 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create special-id-card permission directly
        Permission::firstOrCreate(
            ['name' => 'special-id-card'],
            [
                'fa_name' => 'ثبت کارت ویژه برای کارمندان',
                'group' => 'مشخصات کارمند',
                'guard_name' => 'web'
            ]
        );
    }
}
