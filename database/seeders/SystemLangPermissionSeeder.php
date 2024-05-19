<?php

namespace Database\Seeders;

use App\Support\Defense\PermissionTranslation;
use App\Support\Defense\PersionPermissionTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SystemLangPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create([
            'name' => 'change_language',
            'fa_name' => PersionPermissionTranslation::viewAny(__("Change Application Language",['lang'=>''])),
            'group' => __("System")]);

    }
}
