# System Features

## Core Features

### Card Management

The Card Management system is a central component of Defense8, implemented through the `sq/Card` package. It provides comprehensive functionality for managing ID cards and associated permissions.

#### Key Card Management Features:

1. **Card Creation and Issuance**
   - Template-based card generation
   - QR code and barcode integration
   - Photo capture and integration
   - Multi-level approval workflows

2. **Card Printing**
   - Support for various card printers
   - Print queue management
   - Print history tracking
   - Re-print capabilities with proper authorization

3. **Card Lifecycle Management**
   - Expiration tracking
   - Renewal workflows
   - Revocation processes
   - Extension management

4. **Card Status Tracking**
   - Active cards
   - Expired cards
   - Suspended cards
   - Lost/stolen card reporting

5. **Card Analytics**
   - Usage metrics
   - Expiration forecasting
   - Issuance trends

### Employee Management

The Employee Management system, implemented through the `sq/Employee` package, provides tools for managing employee records, attendance, and related information.

#### Key Employee Management Features:

1. **Employee Records**
   - Comprehensive employee profiles
   - Document management
   - Employment history
   - Department and position tracking

2. **Attendance Tracking**
   - Integration with card system for access logging
   - Manual attendance entry
   - Automated time calculations
   - Overtime and leave tracking

3. **Employee Performance**
   - Performance metrics
   - Rating systems
   - Review cycles
   - Goal setting and tracking

4. **Employee Onboarding/Offboarding**
   - Workflow management
   - Document collection
   - Training tracking
   - Equipment assignment

### Guest Management

The Guest Management system, implemented through the `sq/Guest` package, provides tools for managing visitor access and tracking.

#### Key Guest Management Features:

1. **Guest Registration**
   - Digital and kiosk registration options
   - Pre-registration capability
   - Host assignment
   - Purpose of visit tracking

2. **Guest Cards**
   - Temporary access card issuance
   - Time-limited access controls
   - Area restrictions
   - Card collection tracking

3. **Visit Tracking**
   - Check-in/check-out logging
   - Duration tracking
   - Frequency analysis
   - Blacklist management

4. **Reporting**
   - Current visitors report
   - Historical visit data
   - Visit patterns
   - Security exceptions

### Location Management

The Location Management system, implemented through the `sq/Location` package, provides tools for managing physical locations and access controls.

#### Key Location Management Features:

1. **Location Hierarchy**
   - Building management
   - Floor and zone mapping
   - Room and area definitions
   - Access point tracking

2. **Access Control Integration**
   - Card reader assignments
   - Access level definitions
   - Time-based access restrictions
   - Emergency override protocols

3. **Space Utilization**
   - Occupancy tracking
   - Space allocation
   - Capacity planning
   - Usage analytics

### Oil Management

The Oil Management system, implemented through the `sq/Oil` package, provides tools for tracking oil-related assets and activities.

#### Key Oil Management Features:

1. **Oil Inventory**
   - Stock level tracking
   - Type and grade classification
   - Location tracking
   - Expiration management

2. **Oil Consumption**
   - Usage tracking
   - Allocation by department
   - Consumption trends
   - Cost analysis

3. **Oil Reporting**
   - Inventory reports
   - Consumption analysis
   - Forecasting
   - Compliance reporting

## Administrative Features

### Role-Based Access Control

The system implements comprehensive role-based access control through Laravel Nova and custom policies:

1. **User Roles**
   - Predefined roles (Admin, Manager, Employee, Guest, etc.)
   - Custom role creation
   - Permission assignment
   - Role hierarchy

2. **Permissions**
   - Granular permission controls
   - Resource-level permissions
   - Action-based permissions (view, create, edit, delete)
   - Custom permission definitions

3. **Policy Enforcement**
   - Model policies
   - Gate definitions
   - Middleware enforcement
   - UI element visibility control

### Reporting and Analytics

The system provides extensive reporting and analytics capabilities:

1. **Standard Reports**
   - Card status reports
   - Employee attendance
   - Guest visit logs
   - Location access reports
   - Oil consumption reports

2. **Custom Reports**
   - Report builder interface
   - Saved report configurations
   - Scheduled report generation
   - Export options (PDF, Excel, CSV)

3. **Dashboards**
   - Executive dashboards
   - Department-specific views
   - Real-time metrics
   - Trend analysis

4. **Data Visualization**
   - Charts and graphs
   - Heat maps
   - Timeline views
   - Geographic visualizations

### Audit Logging

The system maintains comprehensive audit logs:

1. **User Activity Tracking**
   - Login/logout events
   - Action logging
   - Resource access tracking
   - Failed attempt logging

2. **Data Change Logging**
   - Before/after state capture
   - Change author tracking
   - Timestamp recording
   - Change reason documentation

3. **System Events**
   - Background job execution
   - System errors
   - Performance issues
   - Configuration changes

### Notifications

The system implements a robust notification system:

1. **Notification Types**
   - In-app notifications
   - Email notifications
   - SMS notifications (where configured)
   - WebSocket real-time alerts

2. **Notification Triggers**
   - Card expiration warnings
   - New card approvals
   - Guest arrivals
   - System alerts
   - Custom event notifications

3. **Notification Preferences**
   - User-configurable preferences
   - Notification frequency settings
   - Do not disturb periods
   - Delivery channel selection

## Integration Features

### API Endpoints

The system provides RESTful APIs for integration with other systems:

1. **Authentication API**
   - Token-based authentication
   - OAuth support
   - Permission scoping
   - Rate limiting

2. **Card Management API**
   - Card status checking
   - Card activation/deactivation
   - Card data retrieval
   - Card issuance triggers

3. **Employee API**
   - Employee data retrieval
   - Attendance logging
   - Profile updates
   - Department mapping

4. **Location API**
   - Access point status
   - Location hierarchy data
   - Occupancy queries
   - Access control integration

### Real-Time Features

The system implements real-time capabilities through WebSockets:

1. **Live Updates**
   - Dashboard metric updates
   - Card status changes
   - Access events
   - System notifications

2. **Collaborative Features**
   - Multi-user editing prevention
   - Activity presence indicators
   - Real-time chat integration
   - Collaborative workflows

### Mobile Support

The system provides mobile-friendly interfaces:

1. **Responsive Design**
   - Mobile-optimized layouts
   - Touch-friendly controls
   - Offline capabilities
   - Low-bandwidth modes

2. **Mobile-Specific Features**
   - Mobile card display
   - QR code scanning
   - Camera integration
   - Location services

## Technical Features

### Localization and Internationalization

The system supports multiple languages and regional settings:

1. **Multi-language Support**
   - Translation management
   - Language switching
   - Default language settings
   - Translation missing handling

2. **Date and Time Formatting**
   - Timezone support
   - Date format localization
   - Calendar systems (including Hijri)
   - Time format preferences

3. **Number and Currency Formatting**
   - Decimal and thousand separators
   - Currency symbol placement
   - Unit conversions
   - Measurement system preferences

### Data Import/Export

The system provides robust data import and export capabilities:

1. **Import Formats**
   - CSV import
   - Excel import
   - API-based import
   - Batch processing

2. **Export Options**
   - PDF generation
   - Excel export
   - CSV export
   - Data feeds

3. **Migration Tools**
   - Legacy system migration
   - Data transformation
   - Validation rules
   - Error handling

### Backup and Recovery

The system includes comprehensive backup functionality:

1. **Backup Types**
   - Database backups
   - File storage backups
   - Configuration backups
   - Complete system snapshots

2. **Backup Scheduling**
   - Automated backup scheduling
   - Retention policies
   - Storage location configuration
   - Verification processes

3. **Recovery Procedures**
   - Point-in-time recovery
   - Selective restoration
   - Emergency recovery
   - Testing procedures 
