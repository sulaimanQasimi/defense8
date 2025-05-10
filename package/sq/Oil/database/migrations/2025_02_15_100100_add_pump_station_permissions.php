<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create pump station management permissions
        $permissions = [
            [
                'name' => 'viewAny-pump-station',
                'fa_name' => 'مشاهده تمام پمپ استیشن ها',
                'group' => 'پمپ استیشن',
                'guard_name' => 'web'
            ],
            [
                'name' => 'view-pump-station',
                'fa_name' => 'مشاهده پمپ استیشن',
                'group' => 'پمپ استیشن',
                'guard_name' => 'web'
            ],
            [
                'name' => 'create-pump-station',
                'fa_name' => 'ایجاد پمپ استیشن',
                'group' => 'پمپ استیشن',
                'guard_name' => 'web'
            ],
            [
                'name' => 'update-pump-station',
                'fa_name' => 'ویرایش پمپ استیشن',
                'group' => 'پمپ استیشن',
                'guard_name' => 'web'
            ],
            [
                'name' => 'delete-pump-station',
                'fa_name' => 'حذف پمپ استیشن',
                'group' => 'پمپ استیشن',
                'guard_name' => 'web'
            ],
            [
                'name' => 'restore-pump-station',
                'fa_name' => 'بازیابی پمپ استیشن',
                'group' => 'پمپ استیشن',
                'guard_name' => 'web'
            ],
            [
                'name' => 'destroy-pump-station',
                'fa_name' => 'حذف دایمی پمپ استیشن',
                'group' => 'پمپ استیشن',
                'guard_name' => 'web'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission['name']
            ], $permission);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permissions = [
            'viewAny-pump-station',
            'view-pump-station',
            'create-pump-station',
            'update-pump-station',
            'delete-pump-station',
            'restore-pump-station',
            'destroy-pump-station',
        ];

        Permission::whereIn('name', $permissions)->delete();
    }
};
