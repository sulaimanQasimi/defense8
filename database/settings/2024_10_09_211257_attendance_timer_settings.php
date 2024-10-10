<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
    public function up(): void
    {
        $this->migrator->add('attendance.start', '08:00 10:30');
        $this->migrator->add('attendance.end', "02:30 04:30");
    }
};
