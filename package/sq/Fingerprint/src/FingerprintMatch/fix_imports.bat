@echo off
echo Running Python Import Fix Utility...
echo.
python fix_imports.py
echo.
echo Import fix process complete.
if "%CMDCMDLINE:"=%" == "%COMSPEC%" pause
if not "%CMDCMDLINE:"=%" == "%COMSPEC%" powershell -Command "Write-Host 'Press any key to continue...' -NoNewLine; $null = $Host.UI.RawUI.ReadKey('NoEcho,IncludeKeyDown'); Write-Host"
