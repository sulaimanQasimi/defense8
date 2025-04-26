# Deployment Guide

## Overview

This guide covers the deployment process for the Defense8 system across different environments. It includes setup instructions, deployment workflows, and best practices for maintaining a reliable production environment.

## Deployment Environments

Defense8 uses multiple environments to ensure proper testing and quality control:

1. **Development**: Individual developer environments
2. **Testing**: Shared environment for integration testing
3. **Staging**: Production-like environment for final verification
4. **Production**: Live environment for end users

## System Requirements

### Production Server Requirements

- PHP 8.2 or higher
- MySQL 8.0+ or PostgreSQL 12+
- Nginx web server (preferred) or Apache
- Redis server for caching and queues
- Minimum 4GB RAM, 2 CPU cores, 40GB SSD
- SSL certificate

### Scaling Considerations

For high-traffic deployments, consider:

- Multiple web servers behind a load balancer
- Primary/replica database setup
- Redis cluster for caching
- Separate servers for background job processing
- CDN for static assets

## Deployment Strategies

### Standard Deployment

For smaller deployments with limited traffic:

- Single server setup with all components
- Deploy directly from Git repository
- Use Laravel's built-in scheduler
- Monitor using Laravel Telescope

### High-Availability Deployment

For mission-critical deployments:

- Multiple web servers behind a load balancer
- Primary/replica database configuration
- Redis cluster for caching and queue management
- Separate queue workers
- CDN for static assets
- Geographic redundancy where possible

## Deployment Workflows

### Using Laravel Forge

[Laravel Forge](https://forge.laravel.com/) provides a simple way to deploy Laravel applications.

1. **Create a server** in Forge and configure it
2. **Connect your repository** (GitHub, GitLab, or Bitbucket)
3. **Configure deployment script**:

   ```bash
   cd $FORGE_SITE_PATH
   git pull origin main
   composer install --no-interaction --prefer-dist --optimize-autoloader
   php artisan migrate --force
   npm ci
   npm run build
   php artisan optimize
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan queue:restart
   ```

4. **Set up deployment triggers** (webhooks)
5. **Configure environment variables**
6. **Set up SSL certificate**
7. **Configure scheduled tasks**
8. **Set up queue workers**

### Using GitHub Actions and Custom Server

For deployments to custom servers, use GitHub Actions:

1. **Create deployment keys** for secure SSH access
2. **Set up GitHub Actions secrets**:
   - `DEPLOY_HOST`: Server hostname
   - `DEPLOY_USER`: SSH username
   - `DEPLOY_KEY`: SSH private key
   - `DEPLOY_PATH`: Application path on server

3. **Create GitHub Actions workflow** (`.github/workflows/deploy-production.yml`):

   ```yaml
   name: Deploy to Production

   on:
     push:
       branches: [ main ]

   jobs:
     deploy:
       runs-on: ubuntu-latest
       steps:
         - uses: actions/checkout@v3
           with:
             fetch-depth: 0

         - name: Setup PHP
           uses: shivammathur/setup-php@v2
           with:
             php-version: '8.2'
             extensions: mbstring, intl, pdo_mysql
             coverage: none

         - name: Install Composer dependencies
           run: composer install --no-dev --optimize-autoloader

         - name: Install NPM dependencies
           run: npm ci

         - name: Build assets
           run: npm run build

         - name: Setup SSH
           uses: webfactory/ssh-agent@v0.5.4
           with:
             ssh-private-key: ${{ secrets.DEPLOY_KEY }}

         - name: Deploy
           run: |
             echo "Deploying to production..."
             ssh -o StrictHostKeyChecking=no ${{ secrets.DEPLOY_USER }}@${{ secrets.DEPLOY_HOST }} << 'EOF'
               cd ${{ secrets.DEPLOY_PATH }}
               git pull origin main
               composer install --no-dev --optimize-autoloader
               php artisan migrate --force
               php artisan optimize
               php artisan config:cache
               php artisan route:cache
               php artisan view:cache
               php artisan queue:restart
             EOF
   ```

### Using Docker Containers

For containerized deployments:

1. **Create a production Dockerfile**:

   ```dockerfile
   FROM php:8.2-fpm-alpine

   # Install dependencies
   RUN apk add --no-cache \
       nginx \
       postgresql-dev \
       libzip-dev \
       oniguruma-dev \
       libpng-dev \
       zip \
       unzip \
       git \
       nodejs \
       npm

   # PHP extensions
   RUN docker-php-ext-install pdo_pgsql mbstring zip exif pcntl bcmath gd

   # Set working directory
   WORKDIR /var/www/html

   # Copy application files
   COPY . /var/www/html/
   
   # Install Composer
   COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
   
   # Install dependencies
   RUN composer install --optimize-autoloader --no-dev
   RUN npm ci && npm run build && rm -rf node_modules
   
   # Set permissions
   RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
   
   # Configure Nginx
   COPY docker/nginx.conf /etc/nginx/http.d/default.conf
   
   # Expose port
   EXPOSE 80
   
   # Start services
   CMD ["docker/start.sh"]
   ```

2. **Create a Docker Compose file** for orchestration:

   ```yaml
   version: '3'
   services:
     app:
       build:
         context: .
         dockerfile: Dockerfile
       volumes:
         - .env:/var/www/html/.env
       ports:
         - "80:80"
       depends_on:
         - database
         - redis
       restart: unless-stopped

     database:
       image: postgres:14
       volumes:
         - db-data:/var/lib/postgresql/data
       environment:
         POSTGRES_DB: ${DB_DATABASE}
         POSTGRES_USER: ${DB_USERNAME}
         POSTGRES_PASSWORD: ${DB_PASSWORD}
       restart: unless-stopped

     redis:
       image: redis:alpine
       volumes:
         - redis-data:/data
       restart: unless-stopped

     queue:
       build:
         context: .
         dockerfile: Dockerfile
       command: ["php", "artisan", "queue:work", "--tries=3"]
       volumes:
         - .env:/var/www/html/.env
       depends_on:
         - database
         - redis
       restart: unless-stopped

   volumes:
     db-data:
     redis-data:
   ```

3. **Deploy using Docker Compose**:

   ```bash
   docker-compose -f docker-compose.yml up -d
   ```

## Environment-Specific Configuration

### Development Environment

- Debug mode enabled
- Detailed error reporting
- No asset compilation
- SQLite or local MySQL/PostgreSQL
- Mailhog for email testing

### Testing Environment

- Debug mode enabled
- No asset compilation
- Test database
- In-memory caching
- Test mail trap

### Staging Environment

- Debug mode disabled
- Compiled assets
- Replica of production database schema
- Redis for caching
- Queue worker configuration
- Mailtrap or test SMTP
- Same server specs as production

### Production Environment

- Debug mode disabled
- Compiled and optimized assets
- Optimized Laravel configuration
- Redis for caching and queues
- Queue workers and supervisor configuration
- Live mail configuration
- Error monitoring integration

## SSL Configuration

### Let's Encrypt with Certbot

1. **Install Certbot**:

   ```bash
   sudo apt update
   sudo apt install certbot python3-certbot-nginx
   ```

2. **Obtain certificate**:

   ```bash
   sudo certbot --nginx -d defense8.example.com
   ```

3. **Set up auto-renewal**:

   ```bash
   sudo certbot renew --dry-run
   ```

### Manual SSL Configuration with Nginx

```nginx
server {
    listen 80;
    server_name defense8.example.com;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name defense8.example.com;
    
    ssl_certificate /etc/letsencrypt/live/defense8.example.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/defense8.example.com/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-GCM-SHA384:ECDHE-ECDSA-CHACHA20-POLY1305:ECDHE-RSA-CHACHA20-POLY1305:DHE-RSA-AES128-GCM-SHA256:DHE-RSA-AES256-GCM-SHA384;
    ssl_prefer_server_ciphers off;
    ssl_session_cache shared:SSL:10m;
    ssl_session_timeout 1d;
    ssl_session_tickets off;
    
    # HSTS
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
    
    # Other security headers
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header X-XSS-Protection "1; mode=block";
    
    root /var/www/defense8/public;
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
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

## Queue Worker Configuration

### Supervisor Setup

1. **Install Supervisor**:

   ```bash
   sudo apt install supervisor
   ```

2. **Create configuration file**:

   ```bash
   sudo nano /etc/supervisor/conf.d/defense8-worker.conf
   ```

3. **Add configuration**:

   ```ini
   [program:defense8-worker]
   process_name=%(program_name)s_%(process_num)02d
   command=php /var/www/defense8/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
   autostart=true
   autorestart=true
   stopasgroup=true
   killasgroup=true
   user=www-data
   numprocs=4
   redirect_stderr=true
   stdout_logfile=/var/www/defense8/storage/logs/worker.log
   stopwaitsecs=3600
   ```

4. **Update Supervisor**:

   ```bash
   sudo supervisorctl reread
   sudo supervisorctl update
   sudo supervisorctl start all
   ```

## Database Management

### Backup Strategy

1. **Create daily backups**:

   ```bash
   mysqldump -u username -p database_name | gzip > /path/to/backups/defense8_$(date +\%Y\%m\%d).sql.gz
   ```

2. **Set up rotation**:

   ```bash
   find /path/to/backups/ -name "defense8_*.sql.gz" -mtime +14 -delete
   ```

3. **Configure automatic backups**:

   ```bash
   crontab -e
   # Add this line to run backup at 2 AM daily
   0 2 * * * mysqldump -u username -p database_name | gzip > /path/to/backups/defense8_$(date +\%Y\%m\%d).sql.gz
   ```

### Database Migrations

Always run migrations as part of the deployment process:

```bash
php artisan migrate --force
```

For major updates, consider using a maintenance mode:

```bash
# Enable maintenance mode
php artisan down --refresh=15

# Run migrations
php artisan migrate --force

# Disable maintenance mode
php artisan up
```

## Monitoring

### Server Monitoring

1. **Set up server monitoring** with tools like:
   - New Relic
   - Datadog
   - Prometheus + Grafana
   - Netdata

2. **Monitor key metrics**:
   - CPU usage
   - Memory usage
   - Disk space
   - Network traffic
   - Process count

### Application Monitoring

1. **Laravel Telescope** for development and debugging
2. **Sentry** or **Bugsnag** for error tracking
3. **Laravel Horizon** for queue monitoring
4. **Custom health checks**:

   ```php
   // routes/web.php
   Route::get('/health', function () {
       $checks = [
           'database' => DB::connection()->getPdo() ? true : false,
           'cache' => Cache::set('health-check', true) && Cache::get('health-check') === true,
           'queue' => try_queue_ping(),
           'storage' => is_writable(storage_path()),
       ];
       
       $status = !in_array(false, $checks) ? 200 : 503;
       
       return response()->json([
           'status' => $status === 200 ? 'ok' : 'error',
           'checks' => $checks,
           'timestamp' => now()->toIso8601String(),
       ], $status);
   });
   ```

## Automated Deployment

### Continuous Integration/Continuous Deployment (CI/CD)

1. **Set up CI pipeline** with GitHub Actions, GitLab CI, or Jenkins:
   - Run tests
   - Check code style
   - Run static analysis
   - Build assets

2. **Automate deployments** based on branches:
   - `develop` branch → Testing environment
   - `staging` branch → Staging environment
   - `main` branch → Production environment

3. **Example GitHub Actions workflow**:

   ```yaml
   name: CI/CD Pipeline

   on:
     push:
       branches: [ develop, staging, main ]
     pull_request:
       branches: [ develop ]

   jobs:
     test:
       runs-on: ubuntu-latest
       steps:
         - uses: actions/checkout@v3
         - name: Set up PHP
           uses: shivammathur/setup-php@v2
           with:
             php-version: '8.2'
             extensions: mbstring, intl, pdo_mysql
         - name: Install Dependencies
           run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist
         - name: Execute tests
           run: vendor/bin/phpunit
         - name: Check code style
           run: vendor/bin/php-cs-fixer fix --dry-run --diff

     deploy-testing:
       needs: test
       if: github.ref == 'refs/heads/develop'
       runs-on: ubuntu-latest
       steps:
         - name: Deploy to testing
           uses: appleboy/ssh-action@master
           with:
             host: ${{ secrets.TEST_HOST }}
             username: ${{ secrets.TEST_USER }}
             key: ${{ secrets.TEST_SSH_KEY }}
             script: cd /var/www/testing && ./deploy.sh

     deploy-staging:
       needs: test
       if: github.ref == 'refs/heads/staging'
       runs-on: ubuntu-latest
       steps:
         - name: Deploy to staging
           uses: appleboy/ssh-action@master
           with:
             host: ${{ secrets.STAGING_HOST }}
             username: ${{ secrets.STAGING_USER }}
             key: ${{ secrets.STAGING_SSH_KEY }}
             script: cd /var/www/staging && ./deploy.sh

     deploy-production:
       needs: test
       if: github.ref == 'refs/heads/main'
       runs-on: ubuntu-latest
       steps:
         - name: Deploy to production
           uses: appleboy/ssh-action@master
           with:
             host: ${{ secrets.PROD_HOST }}
             username: ${{ secrets.PROD_USER }}
             key: ${{ secrets.PROD_SSH_KEY }}
             script: cd /var/www/production && ./deploy.sh
   ```

## Rollback Procedures

In case of deployment issues, follow these rollback procedures:

### Quick Rollback

1. **Revert to the previous Git commit**:

   ```bash
   cd /var/www/defense8
   git reset --hard HEAD~1
   composer install --no-interaction --prefer-dist --optimize-autoloader
   npm ci && npm run build
   php artisan optimize
   ```

2. **Rollback last migration** if needed:

   ```bash
   php artisan migrate:rollback --step=1
   ```

### Comprehensive Rollback

For more complex issues:

1. **Deploy the last known good version**:

   ```bash
   cd /var/www/defense8
   git fetch origin
   git checkout v1.2.3  # last stable tag
   composer install --no-interaction --prefer-dist --optimize-autoloader
   npm ci && npm run build
   php artisan optimize
   ```

2. **Restore database from backup** if necessary:

   ```bash
   gunzip < /path/to/backups/defense8_20230401.sql.gz | mysql -u username -p database_name
   ```

## Security Considerations

### Production Environment Hardening

1. **File Permissions**:

   ```bash
   # Set proper ownership
   sudo chown -R www-data:www-data /var/www/defense8
   
   # Set proper permissions
   sudo find /var/www/defense8 -type f -exec chmod 644 {} \;
   sudo find /var/www/defense8 -type d -exec chmod 755 {} \;
   sudo chmod -R 775 /var/www/defense8/storage /var/www/defense8/bootstrap/cache
   ```

2. **Web Server Configuration**:
   - Disable directory listing
   - Hide server tokens
   - Implement proper MIME types
   - Set up Content Security Policy (CSP)
   - Configure rate limiting

3. **Firewall Configuration**:
   - Allow only necessary ports (80, 443, SSH)
   - Implement IP-based restrictions for admin areas
   - Use fail2ban for SSH protection

### Regular Security Updates

1. **System updates**:

   ```bash
   sudo apt update && sudo apt upgrade -y
   ```

2. **PHP updates**:

   ```bash
   sudo apt update && sudo apt install --only-upgrade php8.2
   ```

3. **Dependency updates**:

   ```bash
   composer update
   npm update
   ```

4. **Set up security scanning** with tools like:
   - Snyk
   - SonarQube
   - OWASP Dependency-Check

## Post-Deployment Tasks

### Cache Warming

1. **Warm up route cache**:

   ```bash
   php artisan route:cache
   ```

2. **Warm up config cache**:

   ```bash
   php artisan config:cache
   ```

3. **Warm up view cache**:

   ```bash
   php artisan view:cache
   ```

### Verification Checks

1. **Check application health**:

   ```bash
   curl -s https://defense8.example.com/health | jq
   ```

2. **Verify critical functionality**:
   - Login system
   - Card creation
   - API endpoints
   - Background jobs

3. **Performance testing**:
   - Run load tests with tools like Apache Bench or JMeter
   - Check response times for critical pages
   - Monitor resource usage during peak loads

## Maintenance Procedures

### Scheduled Maintenance

1. **Enable maintenance mode**:

   ```bash
   php artisan down --render="maintenance" --refresh=15
   ```

2. **Perform maintenance tasks**:
   - System updates
   - Database optimizations
   - Storage cleanup

3. **Disable maintenance mode**:

   ```bash
   php artisan up
   ```

### Database Optimization

1. **Run optimizations regularly**:

   ```bash
   # MySQL
   mysqlcheck -o database_name -u username -p
   
   # PostgreSQL
   VACUUM ANALYZE;
   ```

2. **Schedule optimization in crontab**:

   ```bash
   # Run weekly optimization
   0 2 * * 0 mysqlcheck -o database_name -u username -p
   ```

## Scaling Strategies

### Horizontal Scaling

1. **Add multiple web servers** behind a load balancer
2. **Implement sticky sessions** or session sharing via Redis
3. **Set up database replicas** for read operations
4. **Use distributed Redis** for shared caching

### Vertical Scaling

1. **Increase server resources**:
   - More CPU cores
   - Additional RAM
   - Faster SSDs
   - Optimized network interfaces

2. **Database optimization**:
   - Tune MySQL/PostgreSQL configuration
   - Add indexes for common queries
   - Implement query caching

### Content Delivery

1. **Set up CDN** for static assets:
   - Cloudflare
   - Amazon CloudFront
   - Fastly

2. **Configure asset caching**:

   ```nginx
   # Nginx configuration for static asset caching
   location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg)$ {
       expires 30d;
       add_header Cache-Control "public, no-transform";
   }
   