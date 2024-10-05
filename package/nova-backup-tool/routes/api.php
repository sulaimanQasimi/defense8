<?php

use Illuminate\Support\Facades\Route;
use Spatie\BackupTool\Http\Controllers\BackupsController;
use Spatie\BackupTool\Http\Controllers\BackupStatusesController;
use Spatie\BackupTool\Http\Controllers\CleanBackupsController;
use Spatie\BackupTool\Http\Controllers\DownloadBackupController;

Route::get('backups', BackupsController::class.'@index');
Route::post('backups', BackupsController::class.'@create');

Route::get('download-backup', DownloadBackupController::class);

Route::get('backup-statuses', BackupStatusesController::class.'@index');
Route::post('clean-backups', CleanBackupsController::class);
