# Nova Guest Management System

This documentation covers the Guest management module in the Nova admin panel. The system allows for tracking and managing guests, their hosts, and gate access within the facility.

## Features

### Guest Information Management
- Create and manage guest records with personal details:
  - Name
  - Last Name 
  - Career/Occupation
  - Address
  - Entry Date/Time
  - Host Information
  - Gate Access
  - Conditions/Status
  - Remarks

### Access Control
- Different access levels based on user roles:
  - Host users can only view their own guests
  - Gate checkers can view current day's guests
  - Department-based access restrictions

### Search & Filtering
Advanced filtering options available for:
- Guest Name
- Last Name
- Career
- Address  
- Entry Date
- Entry Gate
- Host

## Usage Guide

### Creating a New Guest Record

1. Click "Create Guest" button
2. Fill in the required fields:
   - Name
   - Last Name
   - Career
   - Address
   - Entry Date/Time (Persian Calendar format)
   - Select Entry Gate
   - Add any special conditions/status tags
   - Optional remarks

### Important Notes

- Guest information cannot be modified after the entry date has passed
- Entry date uses Persian Calendar format (jYYYY/jMM/jDD h:mm a)
- Hosts can only view and manage their own guests
- Gate checkers have restricted view to current day's guests only
- A printable guest pass can be generated via the "Print" link

### Filtering & Search

1. Use the mega filter panel to search by multiple criteria
2. Available filters:
   - Name
   - Last Name
   - Career
   - Address
   - Entry Date
   - Entry Gate
   - Host

### Guest Status Tracking

- Track guest movement through gates using the "Gate Passed" feature
- Add conditions/status tags to indicate guest's current status
- Add remarks for any special notes or instructions

## Access Control Rules

1. Host Users:
   - Can only view their own guests
   - Limited to their department

2. Gate Checkers:
   - View only current day's guests
   - Limited to their assigned departments
   - Can view guest pass details

3. Regular Users:
   - Department-based access
   - Can view guests within their department scope

## Technical Notes

- Guest records are automatically ordered by registration date (newest first)
- Department-based filtering is automatically applied based on user permissions
- After creating a new guest, users are redirected to the guest list
