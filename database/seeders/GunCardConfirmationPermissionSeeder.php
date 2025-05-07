<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Support\Defense\PermissionTranslation;

class GunCardConfirmationPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::firstOrCreate([
            'name' => "confirm-gun-card",
            'fa_name' => 'تایید کارت اسلحه',
            'group' => 'اسلحه',
            'guard_name' => 'web',
        ]);

        Permission::firstOrCreate([
            'name' => "view-gun-card-confirmation",
            'fa_name' => 'مشاهده تایید کارت اسلحه',
            'group' => 'اسلحه',
            'guard_name' => 'web',
        ]);

        $this->command->info('Gun Card Confirmation permissions created successfully!');
    }
}
