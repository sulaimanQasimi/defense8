# SecuGen DLL Copy PowerShell Script

Write-Host "Running SecuGen DLL Copy Utility..." -ForegroundColor Cyan
Write-Host ""

# Get the script directory
$scriptDir = Split-Path -Parent $MyInvocation.MyCommand.Path

# Run the DLL copy script
python "$scriptDir\copy_secugen_dlls.py"

Write-Host ""
Write-Host "Copy process complete." -ForegroundColor Green
Write-Host "Press any key to continue..."
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
