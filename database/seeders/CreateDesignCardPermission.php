<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CreateDesignCardPermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'design-card', 'fa_name' => trans("Design Card"), 'group' => __("Card")]);
        Permission::create(['name' => 'print-card', 'fa_name' => trans("Print Card Frame"), 'group' => __("Card")]);
    }
}
