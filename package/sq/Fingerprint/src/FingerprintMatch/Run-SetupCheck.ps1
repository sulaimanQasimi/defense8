# Fingerprint Matching Setup Check PowerShell Script

Write-Host "Running Fingerprint Matching Setup Check..." -ForegroundColor Cyan
Write-Host ""

# Get the script directory
$scriptDir = Split-Path -Parent $MyInvocation.MyCommand.Path

# Run the setup check script
python "$scriptDir\check_setup.py"

Write-Host ""
Write-Host "Check complete." -ForegroundColor Green
Write-Host "Press any key to continue..."
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")