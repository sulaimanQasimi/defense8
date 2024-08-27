<?php

namespace Database\Seeders;

use App\Support\Defense\PersionPermissionTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Gate;
use App\Support\Defense\GateEumn;
use App\Support\Defense\GatePermissionEumn;
use App\Support\Defense\GateTranslationEnum;
use App\Support\Defense\PermissionTranslation;
use App\Support\RoleEnum;
use Illuminate\Support\Facades\Hash;
use App\Models\Role as ModelsRole;
use Spatie\Permission\Models\Permission;

class Update6 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $collection = collect([
            'Main Card',
            "Armor Vehical Card",
            "Black Mirror Vehical Card",
            "Employee Vehical Card",
            "Card Info",
            "Gun Card",
            'User',
            "Gate",
            "Host",
            "Guest",
            "Guest Option"
            // ... your own models/permission you want to crate
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

        $role = ModelsRole::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        // Give User Super-Admin Role
        $user = \App\Models\User::whereEmail('admin@mod.af')->first(); // enter your email here
        $user->assignRole('super-admin');
        // Administrator User

        Permission::create(['name' => GatePermissionEumn::Kalid, 'fa_name' => GatePermissionEumn::Kalid, 'group' => __("Gate Permission")]);
        Permission::create(['name' => GatePermissionEumn::Obaeda, 'fa_name' => GatePermissionEumn::Obaeda, 'group' => __("Gate Permission")]);
        Permission::create(['name' => GatePermissionEumn::SideWalk, 'fa_name' => GatePermissionEumn::SideWalk, 'group' => __("Gate Permission")]);
        Permission::create(['name' => GatePermissionEumn::Exit , 'fa_name' => GatePermissionEumn::Exit , 'group' => __("Gate Permission")]);

    }
}
