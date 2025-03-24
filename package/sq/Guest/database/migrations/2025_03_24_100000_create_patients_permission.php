<?php

use App\Support\Defense\PermissionTranslation;
use App\Support\Defense\PersionPermissionTranslation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Sq\Guest\Models\Host;
use Sq\Employee\Models\Gate;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $collection = collect([
            "Patient"
            // ... your own models/permission you want to crate
        ]);

        $collection->each(function ($item, $key) {
            // create permissions for each collection item
            Permission::create(['name' => PermissionTranslation::viewAny($item), 'fa_name' => PersionPermissionTranslation::viewAny("مریض"), 'group' => "مریض"]);
            Permission::create(['name' => PermissionTranslation::view($item), 'fa_name' => PersionPermissionTranslation::view("مریض"), 'group' => "مریض"]);
            Permission::create(['name' => PermissionTranslation::create($item), 'fa_name' => PersionPermissionTranslation::create("مریض"), 'group' => "مریض"]);
            Permission::create(['name' => PermissionTranslation::delete($item), 'fa_name' => PersionPermissionTranslation::delete("مریض"), 'group' => "مریض"]);
            Permission::create(['name' => PermissionTranslation::update($item), 'fa_name' => PersionPermissionTranslation::update("مریض"), 'group' => "مریض"]);
            Permission::create(['name' => PermissionTranslation::restore($item), 'fa_name' => PersionPermissionTranslation::restore("مریض"), 'group' => "مریض"]);
            Permission::create(['name' => PermissionTranslation::destroy($item), 'fa_name' => PersionPermissionTranslation::destroy("مریض"), 'group' => "مریض"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $collection = collect([
            "Patient"
            // ... your own models/permission you want to crate
        ]);

        $collection->each(function ($item, $key) {
            // delete permissions for each collection item
            Permission::where('name', PermissionTranslation::viewAny($item))->delete();
            Permission::where('name', PermissionTranslation::view($item))->delete();
            Permission::where('name', PermissionTranslation::create($item))->delete();
            Permission::where('name', PermissionTranslation::delete($item))->delete();
            Permission::where('name', PermissionTranslation::update($item))->delete();
            Permission::where('name', PermissionTranslation::restore($item))->delete();
            Permission::where('name', PermissionTranslation::destroy($item))->delete();
        });
    }
};