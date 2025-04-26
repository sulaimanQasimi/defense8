# Database Documentation

## Overview

Defense8 uses a relational database architecture with MySQL/PostgreSQL as the primary database engine. The database schema follows Laravel conventions and is organized around the key domain entities of the system.

This document provides an overview of the database structure, key tables, relationships, and how they map to the application's models.

## Database Configuration

The database connection is configured in the `.env` file and the `config/database.php` configuration file. The system supports multiple database connections for different purposes:

- **Main Connection**: Primary application database
- **Logs Connection**: Separate connection for logging (optional)
- **Analytics Connection**: Separate connection for analytics (optional)

## Schema Organization

The database schema is organized into several logical groups:

1. **Core**: Essential system tables (users, roles, permissions)
2. **Card Management**: Tables related to the card system
3. **Employee Management**: Tables for employee records
4. **Guest Management**: Tables for guest and visit tracking
5. **Location Management**: Tables for physical locations and access
6. **Oil Management**: Tables for oil inventory and consumption
7. **Vehicle Management**: Tables for vehicle tracking
8. **System**: Supporting tables for system operation

## Key Tables and Relationships

### Core Tables

#### users

Main user accounts table.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar | User's full name |
| email | varchar | Email address (unique) |
| password | varchar | Hashed password |
| two_factor_secret | text | 2FA secret (nullable) |
| two_factor_recovery_codes | text | 2FA recovery codes (nullable) |
| remember_token | varchar | Remember me token |
| email_verified_at | timestamp | When email was verified |
| current_team_id | bigint | Current team ID (nullable) |
| profile_photo_path | varchar | Profile photo path (nullable) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

#### roles

User roles for authorization.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Role name |
| guard_name | varchar | Guard name |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

#### permissions

Permissions for granular access control.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Permission name |
| guard_name | varchar | Guard name |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

#### model_has_roles

Polymorphic pivot table linking models to roles.

| Column | Type | Description |
|--------|------|-------------|
| role_id | bigint | Foreign key to roles |
| model_type | varchar | Model class |
| model_id | bigint | Model ID |

#### model_has_permissions

Polymorphic pivot table linking models to permissions.

| Column | Type | Description |
|--------|------|-------------|
| permission_id | bigint | Foreign key to permissions |
| model_type | varchar | Model class |
| model_id | bigint | Model ID |

#### role_has_permissions

Pivot table linking roles to permissions.

| Column | Type | Description |
|--------|------|-------------|
| permission_id | bigint | Foreign key to permissions |
| role_id | bigint | Foreign key to roles |

### Card Management Tables

#### cards

Main table for identification cards.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| card_number | varchar | Unique card number |
| status | varchar | Card status (active, expired, revoked) |
| type_id | bigint | Foreign key to card_types |
| employee_id | bigint | Foreign key to employees (nullable) |
| guest_id | bigint | Foreign key to guests (nullable) |
| issued_at | timestamp | When the card was issued |
| expires_at | timestamp | When the card expires |
| revoked_at | timestamp | When the card was revoked (nullable) |
| revocation_reason | varchar | Reason for revocation (nullable) |
| created_by | bigint | User who created the card |
| updated_by | bigint | User who last updated the card |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

#### card_types

Types of identification cards.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Type name |
| description | text | Type description |
| validity_period | integer | Default validity in days |
| requires_approval | boolean | Whether requires approval |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

#### card_prints

Records of card printing events.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| card_id | bigint | Foreign key to cards |
| printer | varchar | Printer used |
| status | varchar | Print status |
| printed_by | bigint | User who printed the card |
| printed_at | timestamp | When the card was printed |
| notes | text | Print notes (nullable) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

#### card_templates

Templates for card designs.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Template name |
| description | text | Template description |
| layout | json | Layout configuration |
| is_default | boolean | Whether this is the default template |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

#### card_access_levels

Access levels that can be assigned to cards.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Access level name |
| description | text | Access level description |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

#### card_access_level_assignments

Pivot table linking cards to access levels.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| card_id | bigint | Foreign key to cards |
| access_level_id | bigint | Foreign key to card_access_levels |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

### Employee Management Tables

#### employees

Main employee records.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| user_id | bigint | Foreign key to users (nullable) |
| employee_number | varchar | Unique employee number |
| first_name | varchar | First name |
| last_name | varchar | Last name |
| email | varchar | Email address |
| phone | varchar | Phone number (nullable) |
| department_id | bigint | Foreign key to departments |
| position_id | bigint | Foreign key to positions |
| manager_id | bigint | Foreign key to employees (nullable) |
| hire_date | date | Date of hire |
| termination_date | date | Date of termination (nullable) |
| status | varchar | Employee status |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

#### departments

Company departments.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Department name |
| code | varchar | Department code |
| parent_id | bigint | Foreign key to departments (nullable) |
| manager_id | bigint | Foreign key to employees (nullable) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

#### positions

Job positions.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Position name |
| department_id | bigint | Foreign key to departments |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

#### employee_documents

Documents related to employees.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| employee_id | bigint | Foreign key to employees |
| type | varchar | Document type |
| name | varchar | Document name |
| path | varchar | File path |
| expires_at | timestamp | Expiration date (nullable) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

#### employee_attendance

Employee attendance records.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| employee_id | bigint | Foreign key to employees |
| date | date | Attendance date |
| check_in | timestamp | Check-in time |
| check_out | timestamp | Check-out time (nullable) |
| status | varchar | Attendance status |
| location_id | bigint | Foreign key to locations |
| notes | text | Attendance notes (nullable) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

### Guest Management Tables

#### guests

Guest records.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| first_name | varchar | First name |
| last_name | varchar | Last name |
| email | varchar | Email address (nullable) |
| phone | varchar | Phone number (nullable) |
| company | varchar | Company name (nullable) |
| id_type | varchar | ID type (passport, license, etc.) |
| id_number | varchar | ID number |
| photo_path | varchar | Photo path (nullable) |
| blacklisted | boolean | Whether guest is blacklisted |
| blacklist_reason | text | Reason for blacklisting (nullable) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

#### visits

Guest visit records.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| guest_id | bigint | Foreign key to guests |
| host_id | bigint | Foreign key to employees |
| purpose_id | bigint | Foreign key to visit_purposes |
| check_in_time | timestamp | Check-in time |
| expected_check_out_time | timestamp | Expected check-out time |
| actual_check_out_time | timestamp | Actual check-out time (nullable) |
| status | varchar | Visit status |
| notes | text | Visit notes (nullable) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

#### visit_purposes

Categories of visit purposes.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Purpose name |
| description | text | Purpose description (nullable) |
| requires_approval | boolean | Whether requires pre-approval |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

### Location Management Tables

#### locations

Hierarchical location structure.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Location name |
| code | varchar | Location code |
| type | varchar | Location type (building, floor, room, area) |
| parent_id | bigint | Foreign key to locations (nullable) |
| capacity | integer | Maximum capacity (nullable) |
| description | text | Location description (nullable) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

#### access_points

Physical access control points.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Access point name |
| location_id | bigint | Foreign key to locations |
| type | varchar | Access point type |
| direction | varchar | Entry, exit, or both |
| status | varchar | Operational status |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

#### access_logs

Records of access events.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| access_point_id | bigint | Foreign key to access_points |
| card_id | bigint | Foreign key to cards |
| timestamp | timestamp | Event timestamp |
| direction | varchar | Entry or exit |
| status | varchar | Granted or denied |
| reason | varchar | Reason if denied (nullable) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

### Oil Management Tables

#### oil_types

Types of oil products.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Oil type name |
| description | text | Oil type description |
| unit | varchar | Measurement unit |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

#### oil_inventory

Oil inventory records.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| oil_type_id | bigint | Foreign key to oil_types |
| batch_number | varchar | Batch number |
| quantity | decimal | Quantity |
| location_id | bigint | Foreign key to locations |
| received_date | date | Date received |
| expiry_date | date | Expiration date (nullable) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

#### oil_consumption

Oil consumption records.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| oil_type_id | bigint | Foreign key to oil_types |
| quantity | decimal | Quantity consumed |
| department_id | bigint | Foreign key to departments |
| vehicle_id | bigint | Foreign key to vehicles (nullable) |
| date | date | Consumption date |
| notes | text | Consumption notes (nullable) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

### Vehicle Management Tables

#### vehicles

Vehicle records.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| make | varchar | Vehicle make |
| model | varchar | Vehicle model |
| year | integer | Model year |
| license_plate | varchar | License plate number |
| vin | varchar | Vehicle identification number |
| type_id | bigint | Foreign key to vehicle_types |
| status | varchar | Vehicle status |
| current_location_id | bigint | Foreign key to locations (nullable) |
| current_assignment_id | bigint | Current assignment ID (nullable) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

#### vehicle_types

Types of vehicles.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Type name |
| description | text | Type description |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

#### vehicle_assignments

Vehicle assignment records.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| vehicle_id | bigint | Foreign key to vehicles |
| employee_id | bigint | Foreign key to employees |
| start_date | date | Assignment start date |
| end_date | date | Assignment end date (nullable) |
| purpose | varchar | Assignment purpose |
| status | varchar | Assignment status |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

#### vehicle_maintenance

Vehicle maintenance records.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| vehicle_id | bigint | Foreign key to vehicles |
| maintenance_type | varchar | Type of maintenance |
| date | date | Maintenance date |
| odometer | integer | Odometer reading |
| cost | decimal | Maintenance cost |
| notes | text | Maintenance notes |
| performed_by | varchar | Who performed the maintenance |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

## Database Relationships

### One-to-One Relationships

- `User` hasOne `Employee`
- `Employee` hasOne `User`
- `Employee` hasOne active `Card`

### One-to-Many Relationships

- `Department` hasMany `Employee`
- `Position` hasMany `Employee`
- `Employee` hasMany `Card`
- `Employee` hasMany `EmployeeDocument`
- `Employee` hasMany `EmployeeAttendance`
- `Guest` hasMany `Visit`
- `Guest` hasMany `Card`
- `Employee` (as host) hasMany `Visit`
- `VisitPurpose` hasMany `Visit`
- `Location` hasMany child `Location`
- `Location` hasMany `AccessPoint`
- `OilType` hasMany `OilInventory`
- `OilType` hasMany `OilConsumption`
- `VehicleType` hasMany `Vehicle`
- `Vehicle` hasMany `VehicleAssignment`
- `Vehicle` hasMany `VehicleMaintenance`

### Many-to-Many Relationships

- `User` belongsToMany `Role`
- `Role` belongsToMany `Permission`
- `User` belongsToMany `Permission`
- `Card` belongsToMany `CardAccessLevel`
- `CardAccessLevel` belongsToMany `Location`

### Polymorphic Relationships

- `ActivityLog` morphTo `subject`
- `Comment` morphTo `commentable`
- `Attachment` morphTo `attachable`

## Eloquent Models

The database tables map to Eloquent models throughout the application. Here are the key models and their locations:

### Core Models

- `App\Models\User`: User accounts
- `App\Models\Role`: User roles
- `App\Models\Permission`: System permissions

### Card Models

- `Card\Models\CardBase`: Abstract base card model
- `Package\SQ\Card\Models\Card`: Concrete card implementation
- `Package\SQ\Card\Models\CardType`: Card types
- `Package\SQ\Card\Models\CardPrint`: Card printing records
- `Package\SQ\Card\Models\CardTemplate`: Card design templates
- `Package\SQ\Card\Models\CardAccessLevel`: Card access levels

### Employee Models

- `Package\SQ\Employee\Models\Employee`: Employee records
- `Package\SQ\Employee\Models\Department`: Departments
- `Package\SQ\Employee\Models\Position`: Job positions
- `Package\SQ\Employee\Models\EmployeeDocument`: Employee documents
- `Package\SQ\Employee\Models\EmployeeAttendance`: Attendance records

### Guest Models

- `Package\SQ\Guest\Models\Guest`: Guest records
- `Package\SQ\Guest\Models\Visit`: Visit records
- `Package\SQ\Guest\Models\VisitPurpose`: Visit purpose categories

### Location Models

- `Package\SQ\Location\Models\Location`: Physical locations
- `Package\SQ\Location\Models\AccessPoint`: Access control points
- `Package\SQ\Location\Models\AccessLog`: Access event logs

### Oil Models

- `Package\SQ\Oil\Models\OilType`: Oil product types
- `Package\SQ\Oil\Models\OilInventory`: Oil inventory
- `Package\SQ\Oil\Models\OilConsumption`: Oil consumption records

### Vehicle Models

- `Vehical\Models\Vehicle`: Vehicle records
- `Vehical\Models\VehicleType`: Vehicle types
- `Vehical\Models\VehicleAssignment`: Vehicle assignments
- `Vehical\Models\VehicleMaintenance`: Vehicle maintenance records

## Migrations

The database schema is defined using Laravel migrations located in:

- `database/migrations/`: Core migrations
- `package/sq/*/database/migrations/`: Package-specific migrations
- `modules/*/Database/Migrations/`: Module-specific migrations

## Seeders

Database seeders are used to populate the database with initial data:

- `database/seeders/`: Core seeders
- `package/sq/*/database/seeders/`: Package-specific seeders
- `modules/*/Database/Seeders/`: Module-specific seeders

## Query Optimization

### Indexes

Key indexes have been added to improve query performance:

1. Foreign key columns
2. Frequently queried columns
3. Columns used in sorting
4. Unique constraints

### Query Strategies

The application uses several strategies to optimize database queries:

1. **Eager Loading**: Using Laravel's `with()` method to avoid N+1 query problems
2. **Chunking**: Processing large datasets in chunks to reduce memory usage
3. **Caching**: Caching frequently accessed data using Redis
4. **Query Scopes**: Using Eloquent scopes to encapsulate common query constraints

## Database Maintenance

### Backup Strategy

The system uses Laravel Backup (by Spatie) to:

1. Schedule daily backups
2. Rotate backups (keep 7 daily backups, 4 weekly backups, and 3 monthly backups)
3. Monitor backup health
4. Clean up old backups

### Performance Monitoring

The system monitors database performance using:

1. Laravel Telescope for query logging and analysis
2. Database-specific monitoring tools
3. Periodic execution of `ANALYZE TABLE` commands 
