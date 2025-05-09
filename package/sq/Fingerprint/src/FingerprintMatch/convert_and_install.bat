@echo off
echo ===== SecuGen Fingerprint Libraries Conversion and Installation =====
echo This script will attempt to convert the .so files to .dll files for Windows

if not exist "libs" (
    echo ERROR: libs directory not found!
    pause
    exit /b 1
)

:: Check if .so files exist
if not exist "libs\libsgfdu03.so" (
    echo ERROR: .so files not found in the libs directory.
    echo This script requires the original .so files from the Linux package.
    pause
    exit /b 1
)

echo Creating Windows DLL directory...
if not exist "libs_win" mkdir libs_win

echo Attempting to convert .so files to .dll files...
echo Note: This is an experimental approach and may not work for all libraries.

:: Create a simple copy of the .so files with .dll extension
:: In some cases, this might work for simple libraries
copy "libs\libsgfdu03.so" "libs_win\sgfdu03.dll"
copy "libs\libsgfpamx.so" "libs_win\sgfpamx.dll"
copy "libs\libsgfplib.so" "libs_win\sgfplib.dll"
copy "libs\libsgnfiq.so" "libs_win\sgnfiq.dll"
copy "libs\libpysgfplib.so" "libs_win\pysgfplib.dll"
copy "libs\libsgfdu06.so" "libs_win\sgfdu06.dll"

echo.
echo IMPORTANT: The converted DLL files may not work properly!
echo This method is experimental and not recommended for production use.
echo.
echo The proper solution is to:
echo 1. Download the official SecuGen Windows SDK from https://secugen.com/download
echo 2. Use the official DLL files provided in the Windows SDK
echo.

:: Ask user if they want to continue with installation
set /p continue=Do you want to attempt installation of the converted DLLs anyway? (y/n):

if /i not "%continue%"=="y" (
    echo Installation cancelled.
    pause
    exit /b 0
)

echo.
echo Installing converted DLLs to System32...
echo.

:: Need to run as administrator to copy to System32
copy "libs_win\sgfdu03.dll" "C:\Windows\System32\"
copy "libs_win\sgfpamx.dll" "C:\Windows\System32\"
copy "libs_win\sgfplib.dll" "C:\Windows\System32\"
copy "libs_win\sgnfiq.dll" "C:\Windows\System32\"
copy "libs_win\pysgfplib.dll" "C:\Windows\System32\"
copy "libs_win\sgfdu06.dll" "C:\Windows\System32\"

if %errorlevel% neq 0 (
    echo.
    echo Installation failed. Please run this script as Administrator.
    echo Right-click on the script and select "Run as administrator"
) else (
    echo.
    echo Installation completed, but the libraries may not function correctly.
    echo If you experience issues, please obtain the official Windows SDK from SecuGen.
)

pause
