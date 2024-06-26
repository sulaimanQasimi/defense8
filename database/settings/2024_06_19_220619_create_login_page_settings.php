<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {

        $this->migrator->add('login_page.site_name', 'Spatie');
        $this->migrator->add('login_page.image', null);

    }
};
