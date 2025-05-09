<?php

namespace Sq\Fingerprint\Console\Commands;

use Illuminate\Console\Command;
use Sq\Fingerprint\Models\BiometricData;

class MigrateTemplatesToFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fingerprint:migrate-templates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate fingerprint templates from database to file storage';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting migration of fingerprint templates to file storage...');

        // Create the templates directory if it doesn't exist
        $templatesDir = storage_path('app/fingerprints');
        if (!file_exists($templatesDir)) {
            mkdir($templatesDir, 0755, true);
            $this->info("Created templates directory: {$templatesDir}");
        }

        // Get all biometric data records
        $biometricDataRecords = BiometricData::all();
        $total = $biometricDataRecords->count();

        if ($total === 0) {
            $this->info('No biometric data records found to migrate.');
            return 0;
        }

        $this->info("Found {$total} biometric data records to process.");

        // Set up progress bar
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $migrated = 0;
        $skipped = 0;
        $errors = 0;

        foreach ($biometricDataRecords as $record) {
            // Get template data - prefer ISO template, fall back to regular template
            $templateData = $record->ISOTemplateBase64 ?? $record->TemplateBase64;

            if (empty($templateData)) {
                $this->newLine();
                $this->warn("Skipping record {$record->record_id}: No template data found.");
                $skipped++;
                $bar->advance();
                continue;
            }

            try {
                // Create template file with record ID as the name
                $templateFile = $templatesDir . '/cardinfo_' . $record->record_id . '.dat';

                // Check if file already exists
                if (file_exists($templateFile)) {
                    $this->newLine();
                    $this->warn("File already exists for record {$record->record_id}, skipping.");
                    $skipped++;
                    $bar->advance();
                    continue;
                }

                // Save decoded template to file
                file_put_contents($templateFile, base64_decode($templateData));
                $migrated++;
            } catch (\Exception $e) {
                $this->newLine();
                $this->error("Error migrating record {$record->record_id}: " . $e->getMessage());
                $errors++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Migration completed:");
        $this->info("- Total records: {$total}");
        $this->info("- Successfully migrated: {$migrated}");
        $this->info("- Skipped: {$skipped}");
        $this->info("- Errors: {$errors}");

        return 0;
    }
}
