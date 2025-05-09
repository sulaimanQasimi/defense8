@echo off
echo ===== SecuGen Fingerprint Libraries Installation =====
echo Checking for DLL files...

if not exist "libs\sgfdu03.dll" (
    echo ERROR: DLL files not found in the libs directory.
    echo.
    echo To fix this issue:
    echo 1. Download the SecuGen Windows SDK from https://secugen.com/download
    echo 2. Extract the package and locate the DLL files:
    echo    - sgfdu03.dll
    echo    - sgfpamx.dll
    echo    - sgfplib.dll
    echo    - sgnfiq.dll
    echo    - pysgfplib.dll
    echo    - sgfdu06.dll
    echo 3. Copy these files to the 'libs' directory
    echo 4. Run this install.bat script again
    echo.
    echo Alternatively, you may need to contact SecuGen for the Windows SDK as these files
    echo are proprietary and require proper licensing.
    echo.
    pause
    exit /b 1
)

echo Found DLL files. Installing to System32...

:: Need to run as administrator to copy to System32
copy "libs\libssgfdu03.dll" "C:\Windows\System32\"
copy "libs\libssgfpamx.dll" "C:\Windows\System32\"
copy "libs\libssgfplib.dll" "C:\Windows\System32\"
copy "libs\libssgnfiq.dll" "C:\Windows\System32\"
copy "libs\libspysgfplib.dll" "C:\Windows\System32\"
copy "libs\libssgfdu06.dll" "C:\Windows\System32\"

echo.
if %errorlevel% neq 0 (
    echo Installation failed. Please run this script as Administrator.
    echo Right-click on the script and select "Run as administrator"
) else (
    echo Installation completed successfully!
)

pause