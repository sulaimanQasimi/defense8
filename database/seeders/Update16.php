<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Sq\Employee\Database\Seeders\AddSpecialCardEntryPermission;

class Update16 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(AddSpecialCardEntryPermission::class);
    }
}
