<?php

namespace Sq\Fingerprint\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fingerprint:install {--force : Force overwrite of existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the Fingerprint package resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Installing Fingerprint Package...');

        $this->comment('Publishing configuration...');
        $this->callSilent('vendor:publish', [
            '--provider' => 'Sq\Fingerprint\FingerprintServiceProvider',
            '--tag' => 'config',
            '--force' => $this->option('force'),
        ]);

        $this->comment('Publishing migrations...');
        $this->callSilent('vendor:publish', [
            '--provider' => 'Sq\Fingerprint\FingerprintServiceProvider',
            '--tag' => 'migrations',
            '--force' => $this->option('force'),
        ]);

        $this->comment('Publishing assets...');
        $this->callSilent('vendor:publish', [
            '--provider' => 'Sq\Fingerprint\FingerprintServiceProvider',
            '--tag' => 'public',
            '--force' => $this->option('force'),
        ]);

        // Create storage directory
        $this->createStorageDirectory();

        // Run migrations
        if ($this->confirm('Would you like to run the migrations now?', true)) {
            $this->comment('Running migrations...');
            $this->call('migrate');
        }

        // Check Nova installation and set up Nova resources if Nova is installed
        $this->setupNovaIntegration();

        // Provide examples and instructions
        $this->info('');
        $this->info('Fingerprint package has been installed successfully!');
        $this->info('');
        $this->info('To use the fingerprint functionality in your models:');
        $this->info('1. Add the HasBiometricData trait to your model:');
        $this->info('   use Sq\Fingerprint\Traits\HasBiometricData;');
        $this->info('   class User extends Authenticatable {');
        $this->info('       use HasBiometricData;');
        $this->info('       // ...'); 
        $this->info('   }');
        $this->info('');
        
        // Show Nova instructions only if Nova is installed
        if (class_exists(\Laravel\Nova\Nova::class)) {
            $this->info('2. To use the Nova field, add it to your Nova resource:');
            $this->info('   use Sq\Fingerprint\Nova\Fields\Fingerprint;');
            $this->info('   // ...');
            $this->info('   Fingerprint::make(\'Fingerprint\', \'fingerprint_data\')');
            $this->info('       ->height(300)');
            $this->info('       ->width(300)');
            $this->info('       ->quality(80)');
            $this->info('');
        }
        
        $this->info('3. To verify a fingerprint:');
        $this->info('   $result = $user->verifyFingerprint($isoTemplateBase64);');
        $this->info('   if ($result[\'match\']) {');
        $this->info('       // Fingerprint matches');
        $this->info('   }');
        $this->info('');
    }

    /**
     * Create the fingerprint storage directory.
     *
     * @return void
     */
    protected function createStorageDirectory()
    {
        $path = storage_path('app/fingerprints/temp');

        if (!File::isDirectory($path)) {
            $this->comment('Creating storage directory...');
            
            File::makeDirectory($path, 0755, true);
            File::put($path . '/.gitignore', "*\n!.gitignore\n");
            
            $this->info('Storage directory created at: ' . $path);
        } else {
            $this->info('Storage directory already exists at: ' . $path);
        }
    }

    /**
     * Set up Nova integration if available.
     *
     * @return void
     */
    protected function setupNovaIntegration()
    {
        if (!class_exists(\Laravel\Nova\Nova::class)) {
            $this->comment('Laravel Nova not found. Skipping Nova integration setup.');
            $this->line('  If you want to use the Nova field, you need to install Laravel Nova first.');
            $this->line('  Then you can use the Fingerprint field in your Nova resources.');
            return;
        }

        $this->comment('Laravel Nova detected. Setting up Nova integration...');

        // Add the Nova service provider to config/app.php if it's not already there
        $this->ensureNovaServiceProviderIsRegistered();

        $this->info('Nova integration has been set up successfully!');
    }

    /**
     * Ensure the Nova service provider is registered in the application.
     *
     * @return void
     */
    protected function ensureNovaServiceProviderIsRegistered()
    {
        $appConfig = file_get_contents(config_path('app.php'));

        if (strpos($appConfig, 'Sq\\Fingerprint\\NovaServiceProvider') === false) {
            $this->comment('Adding NovaServiceProvider to config/app.php...');
            
            // Find the providers array
            $pattern = "/('providers' => \[\s*)/";
            $replacement = "$1\        Sq\Fingerprint\NovaServiceProvider::class,\n";
            
            // Add our service provider after the opening of the providers array
            $newConfig = preg_replace($pattern, $replacement, $appConfig);
            
            // Write the modified content back to the file
            if ($newConfig !== $appConfig && $newConfig !== null) {
                file_put_contents(config_path('app.php'), $newConfig);
                $this->info('NovaServiceProvider has been added to config/app.php');
            } else {
                $this->warn('Unable to automatically add NovaServiceProvider to config/app.php. Please add it manually:');
                $this->info('Add "Sq\Fingerprint\NovaServiceProvider::class" to the providers array in config/app.php');
            }
        } else {
            $this->info('NovaServiceProvider is already registered in config/app.php');
        }
    }
} 