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
use Illuminate\Support\Facades\Artisan;
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
        $this->call(Update6::class);
        $this->call(Update7::class);
        $this->call(Update10::class);
        $this->call(Update11::class);
        $this->call(Update12::class);
        $this->call(Update13::class);
        $this->call(Update14::class);
        $this->call(Update15::class);
        $this->call(GunCardConfirmationPermissionSeeder::class);
        Artisan::call('key:generate');
    }
}
