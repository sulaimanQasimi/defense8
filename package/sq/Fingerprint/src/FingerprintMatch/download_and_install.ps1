# SecuGen Fingerprint Libraries Download and Installation Script
# This script attempts to download the SecuGen DLL files from known locations
# and install them into the system

# Ensure we're running as administrator
if (-NOT ([Security.Principal.WindowsPrincipal][Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltInRole] "Administrator")) {
    Write-Warning "Please run this script as Administrator!"
    Write-Host "Right-click on the script and select 'Run as Administrator'" -ForegroundColor Yellow
    Write-Host "Press any key to exit..."
    $null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
    exit
}

Write-Host "===== SecuGen Fingerprint Libraries Download and Installation =====" -ForegroundColor Green

# Create libs directory if it doesn't exist
$libsDir = Join-Path $PSScriptRoot "libs_win"
if (-not (Test-Path $libsDir)) {
    New-Item -ItemType Directory -Path $libsDir | Out-Null
    Write-Host "Created directory: $libsDir" -ForegroundColor Cyan
}

# Define DLL files to download
$dllFiles = @(
    "sgfdu03.dll",
    "sgfpamx.dll",
    "sgfplib.dll",
    "sgnfiq.dll",
    "pysgfplib.dll",
    "sgfdu06.dll"
)

# Note: The actual URLs would need to be filled in with valid links if they exist
# Most proprietary SDKs don't offer direct download links, but we'll set up the structure
$downloadUrls = @{
    "sgfdu03.dll" = $null
    "sgfpamx.dll" = $null
    "sgfplib.dll" = $null
    "sgnfiq.dll" = $null
    "pysgfplib.dll" = $null
    "sgfdu06.dll" = $null
}

$downloaded = $false

foreach ($dll in $dllFiles) {
    $dllPath = Join-Path $libsDir $dll

    # Check if the file already exists locally
    if (Test-Path $dllPath) {
        Write-Host "File already exists: $dll" -ForegroundColor Green
        continue
    }

    # Try to download if URL is available
    if ($downloadUrls[$dll]) {
        try {
            Write-Host "Downloading $dll..." -ForegroundColor Cyan
            Invoke-WebRequest -Uri $downloadUrls[$dll] -OutFile $dllPath
            Write-Host "Downloaded successfully: $dll" -ForegroundColor Green
            $downloaded = $true
        }
        catch {
            Write-Host "Failed to download $dll: $_" -ForegroundColor Red
        }
    }
    else {
        Write-Host "No download URL available for $dll" -ForegroundColor Yellow
    }
}

if (-not $downloaded) {
    Write-Host "`nNo files were downloaded. SecuGen DLL files are proprietary and require proper licensing." -ForegroundColor Yellow
    Write-Host "Please obtain the official Windows SDK from SecuGen: https://secugen.com/download" -ForegroundColor Yellow

    Write-Host "`nDo you want to try downloading the Windows SDK from the SecuGen website? (Y/N)" -ForegroundColor Cyan
    $response = Read-Host

    if ($response -eq "Y" -or $response -eq "y") {
        Start-Process "https://secugen.com/download"
        Write-Host "Browser opened to SecuGen download page. Please download and extract the SDK, then copy the DLL files to the 'libs_win' directory." -ForegroundColor Cyan
    }

    Write-Host "`nPress any key to exit..."
    $null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
    exit
}

# Install DLLs to System32
Write-Host "`nInstalling DLL files to System32..." -ForegroundColor Cyan

foreach ($dll in $dllFiles) {
    $sourcePath = Join-Path $libsDir $dll
    $targetPath = Join-Path $env:SystemRoot "System32" $dll

    if (Test-Path $sourcePath) {
        try {
            Copy-Item -Path $sourcePath -Destination $targetPath -Force
            Write-Host "Installed: $dll" -ForegroundColor Green
        }
        catch {
            Write-Host "Failed to install $dll: $_" -ForegroundColor Red
        }
    }
    else {
        Write-Host "Missing file: $dll - Cannot install" -ForegroundColor Red
    }
}

Write-Host "`nInstallation process completed!" -ForegroundColor Green
Write-Host "If you encounter issues, please obtain the official Windows SDK from SecuGen." -ForegroundColor Yellow

Write-Host "`nPress any key to exit..."
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
