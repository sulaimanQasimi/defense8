<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Gate;
use App\Support\Defense\GateEumn;
use App\Support\Defense\GatePermissionEumn;
use App\Support\Defense\GateTranslationEnum;
use App\Support\Defense\PermissionTranslation;
use App\Support\RoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Sereny\NovaPermissions\Models\Role as ModelsRole;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        \App\Models\User::create([
            'name' => 'Administrator',
            'email' => 'admin@mod.af',
            'password' => Hash::make('123'),
        ]);

        // $collection = collect([
        //     'Main Card',
        //     "Armor Vehical Card",
        //     "Black Mirror Vehical Card",
        //     "Employee Vehical Card",
        //     "Card Info",
        //     "Gun Card",
        //     'User',
        //     "Gate",
        //     "Host",
        //     "Guest",
        //     "Guest Option"
        //     // ... your own models/permission you want to crate
        // ]);

        // $collection->each(function ($item, $key) {
        //     // create permissions for each collection item
        //     Permission::create(['name' => PermissionTranslation::viewAny(__($item))]);
        //     Permission::create(['name' => PermissionTranslation::view(__($item))]);
        //     Permission::create(['name' => PermissionTranslation::create(__($item))]);
        //     Permission::create(['name' => PermissionTranslation::delete(__($item))]);
        //     Permission::create(['name' => PermissionTranslation::update(__($item))]);
        //     Permission::create(['name' => PermissionTranslation::restore(__($item))]);
        //     Permission::create(['name' => PermissionTranslation::destroy(__($item))]);
        // });

        // // Create a Super-Admin Role and assign all permissions to it
        // $role = ModelsRole::create(['name' => 'super-admin']);
        // $role->givePermissionTo(Permission::all());

        // // Give User Super-Admin Role
        // $user = \App\Models\User::whereEmail('admin@mod.af')->first(); // enter your email here
        // $user->assignRole('super-admin');
        // Administrator User

        // Permission::create(['name' => GatePermissionEumn::Kalid]);
        // Permission::create(['name' => GatePermissionEumn::Obaeda]);
        // Permission::create(['name' => GatePermissionEumn::SideWalk]);
        // Permission::create(['name' => GatePermissionEumn::Exit]);

        if (env('APP_ENV') == 'local') {

            $user1 = \App\Models\User::create([
                'name' => 'Ali',
                'email' => 'ali@mod.af',
                'password' => Hash::make('123'),
            ]);
            Gate::query()->create([
                'fa_name' => "قرول خالد",
                'pa_name' => 'د خالد قرول',
                'en_name' => GateEumn::Kalid,
                'user_id' => $user1->id
            ]);
            \App\Models\User::create([
                'name' => 'muhammad',
                'email' => 'muhammad@mod.af',
                'password' => Hash::make('123'),
            ]);

            \App\Models\User::create([
                'name' => 'Kamran',
                'email' => 'kamran@mod.af',
                'password' => Hash::make('123'),
            ]);

            \App\Models\User::create([
                'name' => 'Omar',
                'email' => 'omar@mod.af',
                'password' => Hash::make('123'),
            ]);

        }
    }
}
