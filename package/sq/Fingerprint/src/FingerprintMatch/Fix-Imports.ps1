# Python Import Fix PowerShell Script

Write-Host "Running Python Import Fix Utility..." -ForegroundColor Cyan
Write-Host ""

# Get the script directory
$scriptDir = Split-Path -Parent $MyInvocation.MyCommand.Path

# Run the import fix script
python "$scriptDir\fix_imports.py"

Write-Host ""
Write-Host "Import fix process complete." -ForegroundColor Green
Write-Host "Press any key to continue..."
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")