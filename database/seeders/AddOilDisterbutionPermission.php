<?php

namespace Database\Seeders;

use App\Support\Defense\PermissionTranslation;
use App\Support\Defense\PersionPermissionTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AddOilDisterbutionPermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $collection = collect([
            "Oil",
            // ... your own models/permission you want to crate
        ]);

        $collection->each(function ($item, $key) {
            // create permissions for each collection item
            Permission::create(['name' => PermissionTranslation::viewAny($item), 'fa_name' => PersionPermissionTranslation::viewAny(__("Disterbuted Oil")), 'group' => __("Disterbuted Oil")]);
            Permission::create(['name' => PermissionTranslation::view($item), 'fa_name' => PersionPermissionTranslation::view(__("Disterbuted Oil")), 'group' => __("Disterbuted Oil")]);
            Permission::create(['name' => PermissionTranslation::create($item), 'fa_name' => PersionPermissionTranslation::create(__("Disterbuted Oil")), 'group' => __("Disterbuted Oil")]);
            // Permission::create(['name' => PermissionTranslation::delete($item), 'fa_name' => PersionPermissionTranslation::delete(__("Disterbuted Oil")), 'group' => __("Disterbuted Oil")]);
            // Permission::create(['name' => PermissionTranslation::update($item), 'fa_name' => PersionPermissionTranslation::update(__("Disterbuted Oil")), 'group' => __("Disterbuted Oil")]);
            // Permission::create(['name' => PermissionTranslation::restore($item), 'fa_name' => PersionPermissionTranslation::restore(__("Disterbuted Oil")), 'group' => __("Disterbuted Oil")]);
            // Permission::create(['name' => PermissionTranslation::destroy($item), 'fa_name' => PersionPermissionTranslation::destroy(__("Disterbuted Oil")), 'group' => __("Disterbuted Oil")]);
        });

        Permission::create(['name' =>"access_to_disterbuted_oil_page", 'fa_name' =>"دسترسی مستقیم به صفحه اخذ تیل", 'group' => __("Disterbuted Oil")]);

    }
}
