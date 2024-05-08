<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Update10 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(AddAllGatePermission::class);
        $this->call(AddSeeOtherWebsitePermissionDataSeeder::class);
        $this->call(ApiIntegrationSeeder::class);
        $this->call(AddGateCheckerPermission::class);
        $this->call(DepartmentPermissionSeeder::class);
        $this->call(PrintCardRoleSeeder::class);
        $this->call(AddLocationFullPermission::class);
    }
}
