# Core Modules

## Overview

Defense8 uses core modules located in the `modules/` directory to provide shared functionality across the application. Unlike the custom packages in `package/sq/`, these modules are directly part of the main application codebase but are organized in a modular way to maintain separation of concerns.

The core modules are autoloaded via the `psr-4` configuration in `composer.json`:

```json
"autoload": {
    "psr-4": {
        "App\\": "app/",
        "Database\\Factories\\": "database/factories/",
        "Card\\": "modules/card/",
        "Translation\\": "modules/translation/",
        "Vehical\\": "modules/vehical/",
        "Support\\": "modules/Support/",
        "Database\\Seeders\\": "database/seeders/"
    }
}
```

## Card Module

**Directory:** `modules/card/`

### Purpose

The Card module provides core functionality for working with identification cards in the system. This module serves as a foundation for the more specialized Card package (`package/sq/Card/`), focusing on the fundamental data models and operations.

### Components

#### Data Models

- `CardBase`: Abstract base model for card entities
- `CardStatus`: Enumeration of card statuses
- `CardType`: Enumeration of card types

#### Interfaces

- `CardInterface`: Interface for card operations
- `CardRepositoryInterface`: Interface for card data access
- `CardServiceInterface`: Interface for card services

#### Traits

- `HasCards`: Trait that can be used by models that own cards
- `CardValidation`: Trait for card validation rules
- `CardPresenter`: Trait for card presentation logic

### Integration Points

The Card module integrates with:

- Authentication system for card-based access
- Employee models for card ownership
- Access control systems for permissions

### Key Files

- `modules/card/Models/CardBase.php`: Base model implementation
- `modules/card/Interfaces/CardInterface.php`: Core interface definition
- `modules/card/Traits/HasCards.php`: Trait for models that have cards

## Translation Module

**Directory:** `modules/translation/`

### Purpose

The Translation module handles internationalization (i18n) and localization (l10n) throughout the application. It provides mechanisms for translating text, formatting dates and numbers according to locale, and managing language preferences.

### Components

#### Translation Management

- `TranslationManager`: Central manager for translation operations
- `TranslationLoader`: Loads translations from various sources
- `TranslationCache`: Caches translations for performance

#### Locale Support

- `LocaleManager`: Manages active locale and locale switching
- `LocaleMiddleware`: HTTP middleware for setting locale from request
- `LocaleDetector`: Detects user's preferred locale

#### Language Files

- Default language files in standard Laravel format
- Support for database-stored translations
- JSON-based translation files for JavaScript components

### Integration Points

The Translation module integrates with:

- User preferences for language selection
- Frontend components via JavaScript translations
- Nova admin panel for translation management

### Key Files

- `modules/translation/Manager.php`: Core translation manager
- `modules/translation/ServiceProvider.php`: Service provider
- `modules/translation/Middleware/SetLocale.php`: Locale middleware

## Vehical Module

**Directory:** `modules/vehical/`

### Purpose

The Vehical module manages vehicle information, tracking, and related functionality. It supports fleet management, vehicle assignment, and maintenance tracking.

### Components

#### Data Models

- `Vehicle`: Core vehicle model
- `VehicleType`: Vehicle classifications
- `VehicleMaintenance`: Maintenance record tracking
- `VehicleAssignment`: Tracks vehicle assignments to employees

#### Services

- `VehicleService`: Core service for vehicle operations
- `MaintenanceScheduler`: Schedules vehicle maintenance
- `FuelTrackingService`: Tracks fuel usage

#### Reports

- `VehicleUsageReport`: Reports on vehicle usage
- `MaintenanceReport`: Reports on maintenance history
- `FuelConsumptionReport`: Reports on fuel consumption

### Integration Points

The Vehical module integrates with:

- Employee module for vehicle assignments
- Card module for vehicle access cards
- Location module for vehicle tracking

### Key Files

- `modules/vehical/Models/Vehicle.php`: Core vehicle model
- `modules/vehical/Services/VehicleService.php`: Main service
- `modules/vehical/Reports/VehicleReportGenerator.php`: Report generation

## Support Module

**Directory:** `modules/Support/`

### Purpose

The Support module provides shared utilities, helpers, and common functionality used throughout the application. It serves as a toolkit for other modules and components.

### Components

#### Utilities

- `DateUtils`: Date manipulation helpers
- `StringUtils`: String manipulation utilities
- `FileUtils`: File handling utilities
- `ValidationUtils`: Common validation rules

#### Traits

- `HasFactory`: Extended factory pattern support
- `HasUuid`: UUID generation for models
- `Searchable`: Makes models searchable
- `SoftDeletesWithUser`: Tracks who deleted a record

#### Services

- `PdfGenerator`: PDF generation service
- `CsvExporter`: CSV export service
- `EmailService`: Enhanced email capabilities
- `NotificationService`: Application notifications

### Integration Points

The Support module is used by virtually all other modules and packages in the system, providing common functionality and utilities.

### Key Files

- `modules/Support/Helpers/DateUtils.php`: Date utilities
- `modules/Support/Traits/HasUuid.php`: UUID trait
- `modules/Support/Services/PdfGenerator.php`: PDF generation

## Module Development

### Structure

Each core module follows a consistent structure:

```
modules/[ModuleName]/
├── Config/                  # Module configuration
├── Console/                 # Console commands
├── Database/                # Database migrations
│   ├── Migrations/          # Migration files
│   └── Seeders/             # Seeder files
├── Exceptions/              # Module-specific exceptions
├── Http/                    # HTTP components
│   ├── Controllers/         # Controllers
│   ├── Middleware/          # Middleware
│   └── Requests/            # Form requests
├── Interfaces/              # Interfaces
├── Models/                  # Eloquent models
├── Providers/               # Service providers
├── Routes/                  # Route definitions
├── Services/                # Services
├── Support/                 # Support classes
├── Traits/                  # Traits
└── Views/                   # View templates
```

### Service Providers

Each module typically has its own service provider that:

1. Registers the module's services in the container
2. Registers any event listeners
3. Registers routes if the module has its own endpoints
4. Registers any module-specific middleware
5. Merges module configuration

### Namespacing

Modules use their own namespace as defined in the `composer.json` file. For example:

```php
namespace Card\Services;

class CardService
{
    // Implementation
}
```

### Using Modules

To use functionality from a module, you can import the appropriate classes:

```php
use Card\Models\CardBase;
use Translation\Manager as TranslationManager;
use Vehical\Services\VehicleService;
use Support\Traits\HasUuid;

class MyClass
{
    use HasUuid;
    
    protected $translationManager;
    protected $vehicleService;
    
    public function __construct(TranslationManager $translationManager, VehicleService $vehicleService)
    {
        $this->translationManager = $translationManager;
        $this->vehicleService = $vehicleService;
    }
    
    public function createCard()
    {
        $card = new CardBase();
        // Implementation
    }
}
```

## Module vs. Package

### When to Use a Module

Use a core module when:

1. The functionality is central to the application
2. It provides foundational services for other components
3. It needs deep integration with the core application
4. It doesn't need to be versioned independently

### When to Use a Package

Use a package when:

1. The functionality is more specialized or optional
2. It could potentially be used by other applications
3. It needs to be versioned independently
4. It has its own release cycle

### Dependency Direction

In general, packages may depend on modules, but modules should avoid depending on packages to maintain a clean architecture. 
