#!/bin/bash

# SQ Fingerprint Package Setup Script
# This script automates the setup process for the Fingerprint package

echo "🔍 Setting up SQ Fingerprint Package..."

# Check if npm is installed
if ! command -v npm &> /dev/null; then
    echo "❌ npm is not installed. Please install Node.js and npm first."
    exit 1
fi

# Check if composer is installed
if ! command -v composer &> /dev/null; then
    echo "❌ composer is not installed. Please install Composer first."
    exit 1
fi

# Install PHP dependencies
echo "📦 Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

# Install and build frontend assets
echo "🔨 Building frontend assets..."
npm ci
npm run build

# Clean up node_modules to reduce package size
echo "🧹 Cleaning up node_modules..."
rm -rf node_modules

echo "✅ SQ Fingerprint Package setup completed successfully!"
echo ""
echo "Next steps:"
echo "1. Add the package to your Laravel application:"
echo "   composer require sq/fingerprint"
echo ""
echo "2. Run the installation command:"
echo "   php artisan fingerprint:install"
echo ""
echo "3. Follow the installation guide in the README.md file for more details." 