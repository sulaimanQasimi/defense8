# Installation Guide

## System Requirements

### Server Requirements
- PHP 8.2 or higher
- MySQL 8.0+ or PostgreSQL 12+
- Composer 2.0+
- Node.js 16+ and NPM
- Redis server (for queues, caching, and WebSockets)
- Web server (Apache/Nginx)
- SSL certificate for production environments

### PHP Extensions
- BCMath PHP Extension
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PCRE PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- GD PHP Extension
- Zip PHP Extension

## Installation Steps

### 1. Clone the Repository

```bash
git clone <repository-url> defense8
cd defense8
```

### 2. Install Composer Dependencies

```bash
composer install
```

### 3. Install NPM Dependencies

```bash
npm install
```

### 4. Configure Environment Variables

Copy the example environment file and configure your environment variables:

```bash
cp .env.example .env
```

Edit the `.env` file to set:
- Database connection details
- Application URL
- Mail configuration
- Queue connection
- Redis settings
- Other environment-specific settings

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Run Database Migrations

```bash
php artisan migrate
```

### 7. Seed the Database

```bash
php artisan db:seed
```

### 8. Link Storage

```bash
php artisan storage:link
```

### 9. Compile Assets

```bash
npm run build
```

### 10. Setup Symlinks for Custom Packages

The system uses several custom packages located in the `package/sq/` directory. These packages are automatically linked through the `composer.json` file's repositories configuration.

### 11. Setup Laravel Nova

Laravel Nova is included as a first-party package in the `nova/` directory. It should be set up automatically during the composer install process.

### 12. Set Directory Permissions

Ensure the web server has write access to the following directories:
- `storage/`
- `bootstrap/cache/`

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## Configuration

### Webserver Configuration

#### Apache

Example Apache virtual host configuration:

```apache
<VirtualHost *:80>
    ServerName defense8.example.com
    DocumentRoot /path/to/defense8/public

    <Directory /path/to/defense8/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

Don't forget to enable the rewrite module:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

#### Nginx

Example Nginx configuration:

```nginx
server {
    listen 80;
    server_name defense8.example.com;
    root /path/to/defense8/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Queue Configuration

The system uses Laravel's queue system for background processing. Configure your queue driver in the `.env` file:

```
QUEUE_CONNECTION=redis
```

Then start the queue worker:

```bash
php artisan queue:work --tries=3
```

Consider using a process manager like Supervisor to keep the queue worker running.

### WebSockets Configuration

The system uses Laravel Reverb for WebSockets. Configure in `.env`:

```
REVERB_SERVER_URL=ws://your-server:8080
REVERB_APP_ID=defense8
REVERB_APP_KEY=your-app-key
REVERB_APP_SECRET=your-app-secret
```

Start the Reverb server:

```bash
php artisan reverb:start
```

### Scheduled Tasks

Set up a cron job to run the Laravel scheduler:

```
* * * * * cd /path/to/defense8 && php artisan schedule:run >> /dev/null 2>&1
```

## Post-Installation

### Create an Admin User

```bash
php artisan nova:user
```

Follow the prompts to create an admin user.

### Verify Installation

Access your application in a web browser to verify the installation:

```
https://defense8.example.com
```

Navigate to the Nova admin panel:

```
https://defense8.example.com/nova
```

## Troubleshooting

### Common Issues

#### 1. Permissions Issues

If you encounter permission issues, make sure that the web server user has the correct permissions:

```bash
sudo chown -R $USER:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

#### 2. Composer Memory Limit

If Composer runs out of memory during installation:

```bash
COMPOSER_MEMORY_LIMIT=-1 composer install
```

#### 3. Database Connection Issues

Verify your database credentials in the `.env` file and ensure the database exists.

#### 4. Missing .env File

If you get an error about a missing `.env` file:

```bash
cp .env.example .env
php artisan key:generate
```

#### 5. Storage Symlink Issues

If storage links aren't working:

```bash
php artisan storage:link
```

### Getting Help

If you encounter issues not covered in this guide:
1. Check the Laravel log files in `storage/logs/`
2. Consult the Laravel documentation at https://laravel.com/docs
3. Contact the development team for assistance 
