@echo off
echo Running SecuGen DLL Copy Utility...
echo.
python copy_secugen_dlls.py
echo.
echo Copy process complete.
if "%CMDCMDLINE:"=%" == "%COMSPEC%" pause
if not "%CMDCMDLINE:"=%" == "%COMSPEC%" powershell -Command "Write-Host 'Press any key to continue...' -NoNewLine; $null = $Host.UI.RawUI.ReadKey('NoEcho,IncludeKeyDown'); Write-Host"
