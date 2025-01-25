<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class Update15 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(CreateDesignCardPermission::class);
        $this->call(AddEmployeeConfirmedPermissionSeeder::class);
        Permission::query()->updateOrCreate(['name' => 'quota_oil_update'],['fa_name' => 'ویرایش سهمیه تیل کارمندان', 'group' =>'تیل توزیع شده']);
    }
}
