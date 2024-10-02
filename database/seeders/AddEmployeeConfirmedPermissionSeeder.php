<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AddEmployeeConfirmedPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(attributes: ['name' => "confirm-employee", 'fa_name' =>"تایید کارمند", 'group' => __("Card Info")]);

    }
}
