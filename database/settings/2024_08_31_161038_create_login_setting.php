<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('login.title', 'Spatie');
        $this->migrator->add('login.subtitle', "");

    }
};
