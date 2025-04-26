# Custom Packages

## Overview

Defense8 is built using a modular architecture with several custom packages that provide specific functionality. These packages are designed to be reusable, maintainable, and testable components that can be developed and maintained independently.

Each package follows a consistent structure and follows Laravel best practices for package development. They are located in the `package/sq/` directory and are automatically loaded via the composer.json repositories configuration.

## Card Package

**Directory:** `package/sq/Card/`

### Purpose

The Card package provides comprehensive functionality for managing identification cards, including creating, printing, updating, and tracking cards throughout their lifecycle.

### Key Components

1. **Models**
   - `Card`: Represents a physical identification card
   - `CardTemplate`: Defines the visual layout and fields for cards
   - `CardType`: Different types of cards (employee, visitor, contractor)
   - `CardStatus`: Tracks card statuses (active, expired, revoked)
   - `CardPrint`: Records card printing history

2. **Nova Resources**
   - `CardResource`: Admin interface for managing cards
   - `CardTemplateResource`: Interface for managing card templates
   - `CardTypeResource`: Interface for managing card types

3. **Services**
   - `CardService`: Core business logic for card operations
   - `CardGenerationService`: Handles card creation and numbering
   - `CardPrintService`: Manages card printing workflow
   - `CardExpirationService`: Handles card expiration processes

4. **Policies**
   - `CardPolicy`: Authorization rules for card operations
   - `CardTemplatePolicy`: Authorization for template operations

5. **Events**
   - `CardCreated`: Fired when a new card is created
   - `CardUpdated`: Fired when a card is updated
   - `CardPrinted`: Fired when a card is printed
   - `CardExpired`: Fired when a card expires
   - `CardRevoked`: Fired when a card is revoked

### Usage

```php
// Create a new card
$card = app(CardService::class)->createCard([
    'employee_id' => 123,
    'template_id' => 1,
    'expires_at' => now()->addYear(),
]);

// Check card status
if ($card->isActive()) {
    // Card is active
}

// Revoke a card
app(CardService::class)->revokeCard($card, 'Lost card');

// Print a card
app(CardPrintService::class)->printCard($card, $printer);
```

### Configuration

The Card package provides several configuration options in `config/sq-card.php`:

```php
return [
    'auto_expiration' => true,
    'expiration_notification_days' => [30, 15, 7, 1],
    'card_number_prefix' => 'CARD-',
    'default_validity_period' => 365, // days
    'max_print_attempts' => 3,
    'require_approval' => true,
];
```

## Employee Package

**Directory:** `package/sq/Employee/`

### Purpose

The Employee package provides functionality for managing employee records, documents, and related information. It integrates with the Card package to handle employee ID cards.

### Key Components

1. **Models**
   - `Employee`: Core employee model with personal information
   - `Department`: Represents company departments
   - `Position`: Employee job positions
   - `EmployeeDocument`: Documents related to employees
   - `EmployeeAttendance`: Employee attendance records

2. **Nova Resources**
   - `EmployeeResource`: Admin interface for managing employees
   - `DepartmentResource`: Interface for managing departments
   - `PositionResource`: Interface for managing positions
   - `EmployeeDocumentResource`: Interface for managing documents

3. **Services**
   - `EmployeeService`: Core business logic for employee operations
   - `EmployeeImportService`: Handles importing employee data
   - `EmployeeAttendanceService`: Manages attendance tracking
   - `DocumentManagementService`: Handles employee document operations

4. **Policies**
   - `EmployeePolicy`: Authorization rules for employee operations
   - `DepartmentPolicy`: Authorization for department operations

5. **Events**
   - `EmployeeCreated`: Fired when a new employee is created
   - `EmployeeUpdated`: Fired when an employee is updated
   - `EmployeeTerminated`: Fired when an employee is terminated

### Usage

```php
// Create a new employee
$employee = app(EmployeeService::class)->createEmployee([
    'first_name' => 'John',
    'last_name' => 'Doe',
    'email' => 'john.doe@example.com',
    'department_id' => 1,
    'position_id' => 3,
]);

// Update employee information
app(EmployeeService::class)->updateEmployee($employee, [
    'phone' => '+1-555-123-4567',
]);

// Record employee attendance
app(EmployeeAttendanceService::class)->recordAttendance($employee, [
    'check_in' => now(),
    'location_id' => 1,
]);

// Get employee's active card
$card = $employee->activeCard;
```

### Configuration

The Employee package configuration options in `config/sq-employee.php`:

```php
return [
    'auto_create_user' => true,
    'default_role' => 'employee',
    'document_storage_path' => 'employee-documents',
    'attendance_check_in_grace_period' => 15, // minutes
    'attendance_check_out_grace_period' => 15, // minutes
];
```

## Guest Package

**Directory:** `package/sq/Guest/`

### Purpose

The Guest package manages visitor registration, check-in/check-out processes, and temporary access cards for guests.

### Key Components

1. **Models**
   - `Guest`: Represents a visitor to the facility
   - `Visit`: Records of guest visits
   - `VisitPurpose`: Categorizes reasons for visits
   - `GuestCard`: Temporary guest access cards

2. **Nova Resources**
   - `GuestResource`: Admin interface for managing guests
   - `VisitResource`: Interface for managing visit records
   - `VisitPurposeResource`: Interface for managing visit purposes

3. **Services**
   - `GuestService`: Core business logic for guest operations
   - `VisitService`: Handles visit check-in/check-out
   - `GuestCardService`: Manages temporary guest cards
   - `PreregistrationService`: Handles guest pre-registration

4. **Policies**
   - `GuestPolicy`: Authorization rules for guest operations
   - `VisitPolicy`: Authorization for visit operations

5. **Events**
   - `GuestCreated`: Fired when a new guest is registered
   - `GuestCheckedIn`: Fired when a guest checks in
   - `GuestCheckedOut`: Fired when a guest checks out

### Usage

```php
// Register a new guest
$guest = app(GuestService::class)->registerGuest([
    'first_name' => 'Alice',
    'last_name' => 'Johnson',
    'email' => 'alice@example.com',
    'company' => 'Acme Corp',
    'host_id' => 42, // Employee ID of the host
]);

// Check in a guest
$visit = app(VisitService::class)->checkIn($guest, [
    'purpose_id' => 1,
    'expected_duration' => 120, // minutes
]);

// Issue a temporary card
$card = app(GuestCardService::class)->issueCard($guest, $visit);

// Check out a guest
app(VisitService::class)->checkOut($visit);
```

### Configuration

The Guest package configuration in `config/sq-guest.php`:

```php
return [
    'require_photo' => true,
    'auto_notify_host' => true,
    'max_visit_duration' => 480, // minutes
    'check_out_reminder_after' => 240, // minutes
    'id_verification_required' => true,
];
```

## Location Package

**Directory:** `package/sq/Location/`

### Purpose

The Location package manages physical locations, buildings, floors, rooms, and access points. It provides hierarchical location management and integration with access control systems.

### Key Components

1. **Models**
   - `Location`: Base model for all location types
   - `Building`: Represents physical buildings
   - `Floor`: Building floors
   - `Room`: Rooms within floors
   - `AccessPoint`: Card readers and access points

2. **Nova Resources**
   - `LocationResource`: Admin interface for managing locations
   - `BuildingResource`: Interface for managing buildings
   - `AccessPointResource`: Interface for managing access points

3. **Services**
   - `LocationService`: Core business logic for location operations
   - `AccessControlService`: Manages access control integration
   - `OccupancyService`: Tracks location occupancy

4. **Policies**
   - `LocationPolicy`: Authorization rules for location operations
   - `AccessPointPolicy`: Authorization for access point operations

5. **Events**
   - `LocationCreated`: Fired when a new location is created
   - `AccessGranted`: Fired when access is granted
   - `AccessDenied`: Fired when access is denied

### Usage

```php
// Create a new building
$building = app(LocationService::class)->createLocation([
    'name' => 'Main Building',
    'code' => 'MAIN',
    'type' => 'building',
    'capacity' => 500,
]);

// Create a floor within the building
$floor = app(LocationService::class)->createLocation([
    'name' => 'First Floor',
    'code' => 'MAIN-1F',
    'type' => 'floor',
    'parent_id' => $building->id,
]);

// Check if a card has access to a location
$hasAccess = app(AccessControlService::class)->checkAccess($card, $location);

// Record an access event
app(AccessControlService::class)->recordAccess($card, $accessPoint, 'entry');
```

### Configuration

The Location package configuration in `config/sq-location.php`:

```php
return [
    'hierarchy_levels' => ['building', 'floor', 'room', 'area'],
    'access_log_retention_days' => 90,
    'occupancy_tracking_enabled' => true,
    'max_occupancy_percentage' => 100,
];
```

## Oil Package

**Directory:** `package/sq/Oil/`

### Purpose

The Oil package provides functionality for managing oil inventory, consumption tracking, and reporting.

### Key Components

1. **Models**
   - `OilType`: Different types of oil products
   - `OilInventory`: Oil inventory records
   - `OilConsumption`: Tracks oil usage
   - `OilReport`: Oil consumption reports

2. **Nova Resources**
   - `OilTypeResource`: Admin interface for managing oil types
   - `OilInventoryResource`: Interface for managing inventory
   - `OilConsumptionResource`: Interface for consumption records

3. **Services**
   - `OilInventoryService`: Manages oil inventory
   - `OilConsumptionService`: Tracks oil consumption
   - `OilReportService`: Generates reports

4. **Policies**
   - `OilInventoryPolicy`: Authorization rules for inventory operations
   - `OilConsumptionPolicy`: Authorization for consumption operations

5. **Events**
   - `OilReceived`: Fired when new oil is received
   - `OilConsumed`: Fired when oil is consumed
   - `LowInventoryAlert`: Fired when inventory falls below threshold

### Usage

```php
// Add oil to inventory
$inventory = app(OilInventoryService::class)->addInventory([
    'oil_type_id' => 1,
    'quantity' => 500, // liters
    'batch_number' => 'BATCH-123',
    'received_date' => now(),
]);

// Record oil consumption
app(OilConsumptionService::class)->recordConsumption([
    'oil_type_id' => 1,
    'quantity' => 50, // liters
    'department_id' => 3,
    'notes' => 'Monthly maintenance',
]);

// Generate consumption report
$report = app(OilReportService::class)->generateReport([
    'start_date' => now()->subMonth(),
    'end_date' => now(),
    'department_id' => 3,
]);
```

### Configuration

The Oil package configuration in `config/sq-oil.php`:

```php
return [
    'measurement_unit' => 'liter',
    'low_inventory_threshold_percentage' => 20,
    'enable_automatic_reorder' => false,
    'default_report_period' => 'monthly',
];
```

## Query Package

**Directory:** `package/sq/Query/`

### Purpose

The Query package provides advanced database query utilities, report generation, and data export functionality.

### Key Components

1. **Query Builders**
   - `QueryBuilder`: Extended query builder with additional functionality
   - `ReportBuilder`: Specialized builder for report generation
   - `FilterBuilder`: Builder for applying complex filters

2. **Exports**
   - `ExcelExport`: Handles Excel report generation
   - `PdfExport`: Handles PDF report generation
   - `CsvExport`: Handles CSV export

3. **Services**
   - `QueryService`: Core service for building complex queries
   - `ReportService`: Manages report generation
   - `ExportService`: Handles data export

### Usage

```php
// Build a filtered query
$query = app(QueryService::class)
    ->for(Card::class)
    ->withFilter(['status' => 'active', 'type' => 'employee'])
    ->withDateRange('expires_at', $startDate, $endDate)
    ->sortBy('created_at', 'desc');

// Generate a report
$report = app(ReportService::class)
    ->fromQuery($query)
    ->columns(['card_number', 'status', 'expires_at', 'employee.name'])
    ->groupBy('status')
    ->withTotals()
    ->generate();

// Export the report to Excel
$export = app(ExportService::class)
    ->fromReport($report)
    ->toExcel('card_report.xlsx');
```

### Configuration

The Query package configuration in `config/sq-query.php`:

```php
return [
    'max_execution_time' => 300, // seconds
    'cache_reports' => true,
    'cache_duration' => 3600, // seconds
    'export_storage_path' => 'exports',
    'export_public_url_base' => '/exports',
];
```

## Package Development Guidelines

When working with these packages, follow these guidelines:

### Structure

Each package should follow this structure:

```
package/sq/[PackageName]/
├── config/                   # Configuration files
├── database/                 # Migrations and seeders
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── docs/                     # Package documentation
├── resources/                # Package resources
│   ├── js/                   # JavaScript assets
│   ├── lang/                 # Language files
│   └── views/                # Blade templates
├── routes/                   # Route definitions
├── src/                      # PHP source code
│   ├── Console/              # Console commands
│   ├── Events/               # Event classes
│   ├── Exceptions/           # Exception classes
│   ├── Facades/              # Facades
│   ├── Http/                 # Controllers, middleware, requests
│   ├── Listeners/            # Event listeners
│   ├── Models/               # Eloquent models
│   ├── Nova/                 # Nova resources
│   ├── Policies/             # Authorization policies
│   ├── Providers/            # Service providers
│   └── Services/             # Service classes
└── tests/                    # Test classes
```

### Service Provider

Each package should have a service provider that:

1. Registers the package's services in the container
2. Registers routes
3. Registers event listeners
4. Publishes assets, config, and migrations
5. Loads translations

### Dependencies

Packages should:

1. Declare dependencies in their own composer.json
2. Minimize dependencies on other packages
3. Use interfaces for cross-package dependencies
4. Document required dependencies

### Testing

Packages should include tests:

1. Unit tests for services and models
2. Feature tests for controllers and HTTP endpoints
3. Integration tests for cross-package functionality 
