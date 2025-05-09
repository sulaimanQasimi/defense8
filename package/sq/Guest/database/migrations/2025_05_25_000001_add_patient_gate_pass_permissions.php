<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create permissions for patient gate pass management
        Permission::firstOrCreate([
            'name' => "manage-patient-gate-pass",
            'fa_name' => 'مدیریت گذرگاه های مریض',
            'group' => 'مریض',
            'guard_name' => 'web',
        ]);

        Permission::firstOrCreate([
            'name' => "view-patient-gate-pass",
            'fa_name' => 'مشاهده گذرگاه های مریض',
            'group' => 'مریض',
            'guard_name' => 'web',
        ]);

        // Also add the gun card confirmation permissions
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the permissions if needed
        $permissions = [
            "manage-patient-gate-pass",
            "view-patient-gate-pass",
            "confirm-gun-card",
            "view-gun-card-confirmation"
        ];

        foreach ($permissions as $permission) {
            Permission::where('name', $permission)->delete();
        }
    }
};
