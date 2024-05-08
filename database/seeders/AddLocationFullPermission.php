<?php

namespace Database\Seeders;

use App\Support\Defense\PermissionTranslation;
use App\Support\Defense\PersionPermissionTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AddLocationFullPermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collection = collect([
            'Location',
        ]);

        $collection->each(function ($item, $key) {
            // create permissions for each collection item
            Permission::create(['name' => PermissionTranslation::viewAny($item), 'fa_name' => PersionPermissionTranslation::viewAny(__($item)), 'group' => __($item)]);
            Permission::create(['name' => PermissionTranslation::view($item), 'fa_name' => PersionPermissionTranslation::view(__($item)), 'group' => __($item)]);
            Permission::create(['name' => PermissionTranslation::create($item), 'fa_name' => PersionPermissionTranslation::create(__($item)), 'group' => __($item)]);
            Permission::create(['name' => PermissionTranslation::delete($item), 'fa_name' => PersionPermissionTranslation::delete(__($item)), 'group' => __($item)]);
            Permission::create(['name' => PermissionTranslation::update($item), 'fa_name' => PersionPermissionTranslation::update(__($item)), 'group' => __($item)]);
            Permission::create(['name' => PermissionTranslation::restore($item), 'fa_name' => PersionPermissionTranslation::restore(__($item)), 'group' => __($item)]);
            Permission::create(['name' => PermissionTranslation::destroy($item), 'fa_name' => PersionPermissionTranslation::destroy(__($item)), 'group' => __($item)]);
        });

    }
}
