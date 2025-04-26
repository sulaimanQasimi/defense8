# Development Guide

## Introduction

This guide provides developers with the information needed to effectively work on the Defense8 system. It covers setup, workflows, coding standards, and best practices.

## Development Environment Setup

### Prerequisites

Before you begin, ensure you have the following installed:

- PHP 8.2 or higher
- Composer 2.0+
- Node.js 16+ and NPM
- MySQL 8.0+ or PostgreSQL 12+
- Redis server
- Git

### Local Development Setup

1. **Clone the repository**

   ```bash
   git clone <repository-url> defense8
   cd defense8
   ```

2. **Install dependencies**

   ```bash
   composer install
   npm install
   ```

3. **Set up environment**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure environment variables**

   Edit the `.env` file and configure:
   - Database connection
   - Redis connection
   - Mail settings
   - Other environment-specific settings

5. **Run migrations and seeders**

   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Link storage**

   ```bash
   php artisan storage:link
   ```

7. **Start development servers**

   ```bash
   # Start Laravel server
   php artisan serve

   # Start Vite dev server for frontend assets
   npm run dev

   # Start Laravel Reverb WebSocket server (if needed)
   php artisan reverb:start
   ```

### Docker Development Environment

For Docker-based development:

1. **Clone the repository**

   ```bash
   git clone <repository-url> defense8
   cd defense8
   ```

2. **Start Docker containers**

   ```bash
   docker-compose up -d
   ```

3. **Install dependencies**

   ```bash
   docker-compose exec app composer install
   docker-compose exec app npm install
   ```

4. **Set up environment**

   ```bash
   cp .env.example .env
   docker-compose exec app php artisan key:generate
   ```

5. **Run migrations and seeders**

   ```bash
   docker-compose exec app php artisan migrate
   docker-compose exec app php artisan db:seed
   ```

## Git Workflow

### Branch Strategy

We follow a modified GitFlow workflow:

- `main`: Production-ready code
- `develop`: Main development branch
- `feature/*`: New features
- `bugfix/*`: Bug fixes
- `hotfix/*`: Emergency fixes for production
- `release/*`: Release preparation branches

### Branch Naming Convention

```
<type>/<ticket-number>-<short-description>
```

Examples:
- `feature/DEF-123-add-card-expiration-notification`
- `bugfix/DEF-456-fix-guest-check-in-validation`
- `hotfix/DEF-789-fix-critical-security-issue`

### Commit Message Convention

We follow the [Conventional Commits](https://www.conventionalcommits.org/) specification:

```
<type>(<scope>): <description>

[optional body]

[optional footer(s)]
```

Types:
- `feat`: A new feature
- `fix`: A bug fix
- `docs`: Documentation changes
- `style`: Code style changes (formatting, etc.)
- `refactor`: Code changes that neither fix bugs nor add features
- `perf`: Performance improvements
- `test`: Adding or correcting tests
- `chore`: Changes to the build process or auxiliary tools

Example:
```
feat(card): add card expiration notification system

Implement email notifications for cards expiring within 30 days.
Users can configure notification frequency in their profile settings.

Closes #123
```

### Pull Request Process

1. Create a feature or bugfix branch from `develop`
2. Implement your changes, following the coding standards
3. Write or update tests as needed
4. Push your branch and create a pull request to the `develop` branch
5. Fill out the PR template with:
   - Description of changes
   - Issue/ticket reference
   - Testing instructions
   - Screenshots (if applicable)
6. Request review from at least one team member
7. Address any review comments
8. Once approved, merge the PR using the "Squash and merge" option

## Coding Standards

### PHP Coding Standards

We follow PSR-12 coding standards. Key points:

- Use 4 spaces for indentation
- Class and method names in `PascalCase`
- Property and variable names in `camelCase`
- Constants in `UPPER_CASE`
- One class per file
- Namespace declaration on its own line
- Opening braces on the same line as the declaration
- Closing braces on their own line

We use PHP-CS-Fixer for automatic code style enforcement:

```bash
composer cs-fix
```

### JavaScript Coding Standards

For JavaScript/Vue.js, we follow the Airbnb JavaScript Style Guide with some modifications:

- Use 2 spaces for indentation
- Prefer arrow functions when appropriate
- Use `const` by default, `let` when necessary
- Avoid `var`
- Use template literals for string interpolation
- Use destructuring assignment when possible

We use ESLint and Prettier for automatic code style enforcement:

```bash
npm run lint
npm run format
```

### Database Conventions

- Table names should be plural, lowercase, and snake_case
- Primary key should be `id`
- Foreign keys should be singular model name followed by `_id`
- Timestamps should be `created_at` and `updated_at`
- Soft deletes should use `deleted_at`
- Create indexes for frequently queried columns
- Always use migrations for schema changes

## Architecture Patterns

### Service Pattern

Business logic should be encapsulated in dedicated service classes:

```php
namespace App\Services;

class CardService
{
    public function createCard(array $data)
    {
        // Business logic for creating a card
    }

    public function revokeCard(Card $card, string $reason)
    {
        // Business logic for revoking a card
    }
}
```

### Repository Pattern

Data access should be abstracted through repository classes:

```php
namespace App\Repositories;

class CardRepository
{
    public function find(int $id)
    {
        return Card::findOrFail($id);
    }

    public function getActiveCards()
    {
        return Card::where('status', 'active')->get();
    }

    public function getExpiringSoon(int $days = 30)
    {
        return Card::where('status', 'active')
            ->whereDate('expires_at', '<=', now()->addDays($days))
            ->get();
    }
}
```

### Action Classes

For complex operations that don't fit well in a service, use action classes:

```php
namespace App\Actions;

class ImportEmployeesFromCsv
{
    public function execute(UploadedFile $file, array $options = [])
    {
        // Logic for importing employees from CSV
    }
}
```

## Testing

### Test Types

We maintain several types of tests:

1. **Unit Tests**: Test individual components in isolation
2. **Feature Tests**: Test features across multiple components
3. **Integration Tests**: Test integration between components
4. **Browser Tests**: Test UI interactions with Laravel Dusk

### Test Naming Convention

Test methods should clearly describe what they're testing:

```php
/** @test */
public function it_sends_notification_when_card_is_about_to_expire()
{
    // Test logic
}
```

Or using the `test` prefix:

```php
public function test_sends_notification_when_card_is_about_to_expire()
{
    // Test logic
}
```

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test --filter=CardServiceTest

# Run specific test method
php artisan test --filter=CardServiceTest::test_sends_notification_when_card_is_about_to_expire
```

### Test Coverage

We aim for high test coverage, especially for core business logic. Use PHPUnit's coverage features:

```bash
php artisan test --coverage
```

## Documentation

### Code Documentation

All classes, public methods, and complex logic should be documented using PHPDoc comments:

```php
/**
 * Create a new card for an employee.
 *
 * @param int $employeeId The ID of the employee
 * @param array $cardData Card details
 * @param bool $notify Whether to notify the employee
 * @return \App\Models\Card The created card
 * @throws \App\Exceptions\CardException If validation fails
 */
public function createEmployeeCard(int $employeeId, array $cardData, bool $notify = true)
{
    // Implementation
}
```

### API Documentation

API endpoints should be documented using PHPDoc comments in controllers. We use these comments to generate API documentation.

```php
/**
 * Create a new card
 *
 * @OA\Post(
 *     path="/api/v1/cards",
 *     tags={"Cards"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CardRequest")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Card created successfully",
 *         @OA\JsonContent(ref="#/components/schemas/CardResource")
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error"
 *     )
 * )
 */
public function store(CardRequest $request)
{
    // Implementation
}
```

## Common Development Tasks

### Creating a New Feature

1. Create a feature branch from `develop`
2. Create or update models as needed
3. Create or update migrations
4. Implement repositories and services
5. Create or update controllers
6. Implement frontend components
7. Create or update tests
8. Update documentation
9. Submit a pull request

### Adding a Database Migration

1. Create a new migration:

   ```bash
   php artisan make:migration add_expires_at_to_cards_table
   ```

2. Implement the migration:

   ```php
   public function up()
   {
       Schema::table('cards', function (Blueprint $table) {
           $table->timestamp('expires_at')->nullable()->after('issued_at');
       });
   }

   public function down()
   {
       Schema::table('cards', function (Blueprint $table) {
           $table->dropColumn('expires_at');
       });
   }
   ```

3. Run the migration:

   ```bash
   php artisan migrate
   ```

### Creating API Endpoints

1. Create a controller:

   ```bash
   php artisan make:controller API/CardController --api
   ```

2. Define routes in `routes/api.php`:

   ```php
   Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
       Route::apiResource('cards', API\CardController::class);
   });
   ```

3. Implement controller methods
4. Create form requests for validation:

   ```bash
   php artisan make:request API/CardRequest
   ```

5. Create API resources for response formatting:

   ```bash
   php artisan make:resource CardResource
   ```

### Adding Nova Resources

1. Create a Nova resource:

   ```bash
   php artisan nova:resource Card
   ```

2. Customize fields, relationships, and actions
3. Add to Nova sidebar if needed
4. Implement policies for authorization

## Troubleshooting

### Common Issues and Solutions

1. **Composer Dependencies Issues**

   ```bash
   composer clear-cache
   composer update
   ```

2. **Node.js Dependencies Issues**

   ```bash
   rm -rf node_modules
   npm cache clean --force
   npm install
   ```

3. **Database Migration Issues**

   ```bash
   php artisan migrate:fresh --seed
   ```

4. **Permission Issues**

   ```bash
   chmod -R 775 storage bootstrap/cache
   sudo chown -R $USER:www-data storage bootstrap/cache
   ```

5. **Cache Issues**

   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

### Debugging Tips

1. **Laravel Telescope**

   Use Laravel Telescope to inspect requests, exceptions, logs, and database queries:

   ```
   /telescope
   ```

2. **Laravel Debugbar**

   For frontend debugging, use Laravel Debugbar.

3. **Log Files**

   Check log files in `storage/logs/`.

4. **Xdebug**

   Configure Xdebug in your IDE for step-through debugging.

5. **Vue Devtools**

   Use Vue Devtools browser extension for Vue component debugging.

## Performance Optimization

### Database Optimization

1. Use eager loading to avoid N+1 query problems:

   ```php
   $cards = Card::with('employee', 'cardType')->get();
   ```

2. Use chunking for processing large datasets:

   ```php
   Card::chunk(100, function ($cards) {
       foreach ($cards as $card) {
           // Process card
       }
   });
   ```

3. Use query caching for expensive queries:

   ```php
   $cards = Cache::remember('active_cards', 3600, function () {
       return Card::where('status', 'active')->get();
   });
   ```

### Frontend Optimization

1. Use code splitting for Vue components:

   ```javascript
   const CardList = () => import('./components/CardList.vue');
   ```

2. Lazy load images and components
3. Minimize and optimize assets:

   ```bash
   npm run build
   ```

## Security Practices

1. **Validate all input**:

   ```php
   $validated = $request->validate([
       'name' => 'required|string|max:255',
       'email' => 'required|email|unique:users,email',
   ]);
   ```

2. **Use CSRF protection** for all forms
3. **Sanitize output** to prevent XSS
4. **Use parameterized queries** to prevent SQL injection
5. **Implement proper authentication** and authorization
6. **Use HTTPS** for all production traffic
7. **Keep dependencies updated**:

   ```bash
   composer update --with-all-dependencies
   npm update
   ```

## Deployment

See the [Deployment Guide](deployment.md) for detailed information on deploying the application to different environments. 
