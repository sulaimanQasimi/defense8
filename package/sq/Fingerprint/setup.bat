@echo off
echo 🔍 Setting up SQ Fingerprint Package...

REM Check if npm is installed
where npm >nul 2>nul
if %ERRORLEVEL% neq 0 (
    echo ❌ npm is not installed. Please install Node.js and npm first.
    exit /b 1
)

REM Check if composer is installed
where composer >nul 2>nul
if %ERRORLEVEL% neq 0 (
    echo ❌ composer is not installed. Please install Composer first.
    exit /b 1
)

REM Install PHP dependencies
echo 📦 Installing PHP dependencies...
composer install --no-dev --optimize-autoloader

REM Install and build frontend assets
echo 🔨 Building frontend assets...
call npm ci
call npm run build

REM Clean up node_modules to reduce package size
echo 🧹 Cleaning up node_modules...
if exist node_modules rmdir /s /q node_modules

echo ✅ SQ Fingerprint Package setup completed successfully!
echo.
echo Next steps:
echo 1. Add the package to your Laravel application:
echo    composer require sq/fingerprint
echo.
echo 2. Run the installation command:
echo    php artisan fingerprint:install
echo.
echo 3. Follow the installation guide in the README.md file for more details. 