@echo off
echo Running Fingerprint Matching Setup Check...
echo.
python check_setup.py
echo.
echo Check complete.
if "%CMDCMDLINE:"=%" == "%COMSPEC%" pause
if not "%CMDCMDLINE:"=%" == "%COMSPEC%" powershell -Command "Write-Host 'Press any key to continue...' -NoNewLine; $null = $Host.UI.RawUI.ReadKey('NoEcho,IncludeKeyDown'); Write-Host"
