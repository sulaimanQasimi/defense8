<?php

namespace Database\Seeders;

use App\Support\Defense\EditAditionalCardInfoEnum;
use App\Support\Defense\PermissionTranslation;
use App\Support\Defense\PersionPermissionTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class Update7 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Permission::create(['name' => EditAditionalCardInfoEnum::Remark, 'fa_name' => PersionPermissionTranslation::update(__("Remark")), 'group' => __("Card Info")]);
        Permission::create(['name' => EditAditionalCardInfoEnum::Option, 'fa_name' => PersionPermissionTranslation::update(__("Option")), 'group' => __("Card Info")]);
    }
}
