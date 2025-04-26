# API Reference

## Introduction

Defense8 provides a comprehensive RESTful API that allows external systems to interact with the platform. This reference documents all available endpoints, authentication methods, request parameters, and response formats.

## Base URL

All API URLs referenced in this documentation have the following base:

```
https://[your-domain]/api/v1
```

## Authentication

### Obtaining API Tokens

The API uses Laravel Sanctum for token-based authentication. To obtain a token:

```http
POST /api/auth/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password"
}
```

Response:

```json
{
  "token": "1|abcdef123456...",
  "expires_at": "2023-12-31T23:59:59Z"
}
```

### Using API Tokens

Include the token in the `Authorization` header for all API requests:

```http
GET /api/v1/cards
Authorization: Bearer 1|abcdef123456...
```

### Token Permissions

API tokens can be scoped to specific permissions. By default, a token has access to all endpoints the user has permission to access.

## Error Handling

The API uses standard HTTP status codes to indicate the success or failure of an API request.

### Common Error Codes

- `400 Bad Request` - The request could not be understood or was missing required parameters
- `401 Unauthorized` - Authentication failed or user doesn't have permissions
- `403 Forbidden` - User is authenticated but doesn't have permission to access the resource
- `404 Not Found` - Resource could not be found
- `422 Unprocessable Entity` - Request validation error
- `429 Too Many Requests` - Rate limit exceeded
- `500 Internal Server Error` - Server error occurred

### Error Response Format

```json
{
  "message": "The given data was invalid.",
  "errors": {
    "field_name": [
      "Validation error message"
    ]
  }
}
```

## Rate Limiting

API requests are subject to rate limiting to prevent abuse. Current limits are:

- 60 requests per minute for authenticated users
- 10 requests per minute for unauthenticated requests

When a rate limit is exceeded, a `429 Too Many Requests` response will be returned.

## Pagination

List endpoints support pagination using the `page` and `per_page` query parameters:

```http
GET /api/v1/cards?page=2&per_page=15
```

Pagination information is included in the response:

```json
{
  "data": [...],
  "links": {
    "first": "https://[your-domain]/api/v1/cards?page=1",
    "last": "https://[your-domain]/api/v1/cards?page=5",
    "prev": "https://[your-domain]/api/v1/cards?page=1",
    "next": "https://[your-domain]/api/v1/cards?page=3"
  },
  "meta": {
    "current_page": 2,
    "from": 16,
    "last_page": 5,
    "path": "https://[your-domain]/api/v1/cards",
    "per_page": 15,
    "to": 30,
    "total": 75
  }
}
```

## Card API

### List Cards

```http
GET /api/v1/cards
```

Query Parameters:
- `status` (string, optional): Filter by card status (active, expired, suspended)
- `type` (string, optional): Filter by card type
- `search` (string, optional): Search by card number, employee name, or ID
- `expired_before` (date, optional): Filter cards expiring before this date
- `expired_after` (date, optional): Filter cards expiring after this date
- `department_id` (integer, optional): Filter by department ID
- `sort` (string, optional): Sort field and direction (e.g., `created_at:desc`)

Response:

```json
{
  "data": [
    {
      "id": 1,
      "card_number": "EMP-12345",
      "status": "active",
      "type": "employee",
      "issued_at": "2023-01-15T08:30:00Z",
      "expired_at": "2024-01-15T08:30:00Z",
      "employee": {
        "id": 42,
        "name": "John Doe",
        "department": "IT"
      },
      "created_at": "2023-01-15T08:30:00Z",
      "updated_at": "2023-01-15T08:30:00Z"
    }
  ],
  "links": {...},
  "meta": {...}
}
```

### Get Card Details

```http
GET /api/v1/cards/{id}
```

Path Parameters:
- `id` (integer, required): The ID of the card

Response:

```json
{
  "data": {
    "id": 1,
    "card_number": "EMP-12345",
    "status": "active",
    "type": "employee",
    "issued_at": "2023-01-15T08:30:00Z",
    "expired_at": "2024-01-15T08:30:00Z",
    "printed_at": "2023-01-15T09:45:00Z",
    "print_count": 1,
    "employee": {
      "id": 42,
      "name": "John Doe",
      "email": "john.doe@example.com",
      "position": "Software Developer",
      "department": "IT",
      "photo_url": "https://example.com/photos/jdoe.jpg"
    },
    "access_levels": [
      {
        "id": 1,
        "name": "Main Building",
        "description": "Access to main building entrances"
      },
      {
        "id": 3,
        "name": "IT Department",
        "description": "Access to IT department areas"
      }
    ],
    "access_history": [
      {
        "location_name": "Main Entrance",
        "timestamp": "2023-03-15T08:15:22Z",
        "direction": "in"
      },
      {
        "location_name": "Main Entrance",
        "timestamp": "2023-03-15T17:45:12Z",
        "direction": "out"
      }
    ],
    "created_at": "2023-01-15T08:30:00Z",
    "updated_at": "2023-01-15T08:30:00Z"
  }
}
```

### Create Card

```http
POST /api/v1/cards
Content-Type: application/json

{
  "employee_id": 42,
  "type": "employee",
  "expires_at": "2024-01-15T08:30:00Z",
  "access_level_ids": [1, 3, 5]
}
```

Request Body:
- `employee_id` (integer, required): Employee ID to associate with the card
- `type` (string, required): Card type (employee, visitor, contractor)
- `expires_at` (datetime, required): Card expiration date and time
- `access_level_ids` (array of integers, optional): Access levels to assign
- `notes` (string, optional): Additional notes for the card

Response:

```json
{
  "data": {
    "id": 124,
    "card_number": "EMP-12345",
    "status": "active",
    "type": "employee",
    "issued_at": "2023-04-01T14:22:36Z",
    "expired_at": "2024-01-15T08:30:00Z",
    "employee": {
      "id": 42,
      "name": "John Doe",
      "department": "IT"
    },
    "created_at": "2023-04-01T14:22:36Z",
    "updated_at": "2023-04-01T14:22:36Z"
  }
}
```

### Update Card

```http
PUT /api/v1/cards/{id}
Content-Type: application/json

{
  "status": "suspended",
  "expires_at": "2024-06-15T08:30:00Z",
  "access_level_ids": [1, 3, 7]
}
```

Path Parameters:
- `id` (integer, required): The ID of the card

Request Body:
- `status` (string, optional): New card status
- `expires_at` (datetime, optional): New expiration date and time
- `access_level_ids` (array of integers, optional): Updated access levels
- `notes` (string, optional): Updated notes

Response:

```json
{
  "data": {
    "id": 124,
    "card_number": "EMP-12345",
    "status": "suspended",
    "type": "employee",
    "issued_at": "2023-04-01T14:22:36Z",
    "expired_at": "2024-06-15T08:30:00Z",
    "employee": {
      "id": 42,
      "name": "John Doe",
      "department": "IT"
    },
    "created_at": "2023-04-01T14:22:36Z",
    "updated_at": "2023-04-02T09:15:21Z"
  }
}
```

### Delete Card

```http
DELETE /api/v1/cards/{id}
```

Path Parameters:
- `id` (integer, required): The ID of the card

Response:

```json
{
  "message": "Card successfully deleted",
  "deleted_at": "2023-04-02T10:30:45Z"
}
```

## Employee API

### List Employees

```http
GET /api/v1/employees
```

Query Parameters:
- `department_id` (integer, optional): Filter by department ID
- `position` (string, optional): Filter by position
- `search` (string, optional): Search by name, email, or ID
- `has_active_card` (boolean, optional): Filter employees with active cards
- `sort` (string, optional): Sort field and direction (e.g., `name:asc`)

Response:

```json
{
  "data": [
    {
      "id": 42,
      "name": "John Doe",
      "email": "john.doe@example.com",
      "position": "Software Developer",
      "department": {
        "id": 3,
        "name": "IT"
      },
      "has_active_card": true,
      "created_at": "2022-06-01T10:00:00Z",
      "updated_at": "2023-01-10T14:30:22Z"
    }
  ],
  "links": {...},
  "meta": {...}
}
```

### Get Employee Details

```http
GET /api/v1/employees/{id}
```

Path Parameters:
- `id` (integer, required): The ID of the employee

Response:

```json
{
  "data": {
    "id": 42,
    "name": "John Doe",
    "email": "john.doe@example.com",
    "phone": "+1-555-123-4567",
    "position": "Software Developer",
    "department": {
      "id": 3,
      "name": "IT"
    },
    "manager": {
      "id": 36,
      "name": "Jane Smith"
    },
    "hire_date": "2022-06-01",
    "photo_url": "https://example.com/photos/jdoe.jpg",
    "cards": [
      {
        "id": 124,
        "card_number": "EMP-12345",
        "status": "active",
        "expires_at": "2024-01-15T08:30:00Z"
      }
    ],
    "attendance": {
      "this_month": {
        "days_present": 18,
        "days_absent": 2,
        "hours_worked": 144
      }
    },
    "created_at": "2022-06-01T10:00:00Z",
    "updated_at": "2023-01-10T14:30:22Z"
  }
}
```

## Guest API

### List Guests

```http
GET /api/v1/guests
```

Query Parameters:
- `status` (string, optional): Filter by status (checked_in, checked_out)
- `visit_date` (date, optional): Filter by visit date
- `host_id` (integer, optional): Filter by host employee ID
- `search` (string, optional): Search by name, email, or ID

Response:

```json
{
  "data": [
    {
      "id": 75,
      "name": "Alice Johnson",
      "company": "Acme Corp",
      "status": "checked_in",
      "check_in_time": "2023-04-02T09:30:00Z",
      "host": {
        "id": 42,
        "name": "John Doe"
      },
      "card": {
        "id": 256,
        "card_number": "GUEST-5678"
      },
      "created_at": "2023-04-02T09:25:12Z",
      "updated_at": "2023-04-02T09:30:00Z"
    }
  ],
  "links": {...},
  "meta": {...}
}
```

## Location API

### List Locations

```http
GET /api/v1/locations
```

Query Parameters:
- `type` (string, optional): Filter by location type (building, floor, room)
- `parent_id` (integer, optional): Filter by parent location ID
- `search` (string, optional): Search by name or code

Response:

```json
{
  "data": [
    {
      "id": 1,
      "name": "Main Building",
      "code": "MAIN",
      "type": "building",
      "capacity": 500,
      "current_occupancy": 342,
      "children": [
        {
          "id": 5,
          "name": "Ground Floor",
          "type": "floor"
        },
        {
          "id": 6,
          "name": "First Floor",
          "type": "floor"
        }
      ],
      "created_at": "2021-01-01T00:00:00Z",
      "updated_at": "2021-01-01T00:00:00Z"
    }
  ],
  "links": {...},
  "meta": {...}
}
```

## Report API

### Available Reports

```http
GET /api/v1/reports
```

Response:

```json
{
  "data": [
    {
      "id": "card_status",
      "name": "Card Status Report",
      "description": "Report on card statuses by type and department",
      "parameters": [
        {
          "name": "start_date",
          "type": "date",
          "required": true
        },
        {
          "name": "end_date",
          "type": "date",
          "required": true
        },
        {
          "name": "department_id",
          "type": "integer",
          "required": false
        }
      ]
    }
  ]
}
```

### Generate Report

```http
POST /api/v1/reports/generate
Content-Type: application/json

{
  "report_id": "card_status",
  "parameters": {
    "start_date": "2023-01-01",
    "end_date": "2023-03-31",
    "department_id": 3
  },
  "format": "pdf"
}
```

Request Body:
- `report_id` (string, required): ID of the report to generate
- `parameters` (object, required): Report parameters
- `format` (string, required): Output format (pdf, excel, csv)

Response:

```json
{
  "data": {
    "report_url": "https://example.com/reports/card_status_20230402123456.pdf",
    "expires_at": "2023-04-09T12:34:56Z"
  }
}
```

## Webhook API

### List Webhooks

```http
GET /api/v1/webhooks
```

Response:

```json
{
  "data": [
    {
      "id": 1,
      "url": "https://example.com/webhook-receiver",
      "events": ["card.created", "card.updated", "card.expired"],
      "active": true,
      "created_at": "2022-12-01T00:00:00Z",
      "updated_at": "2022-12-01T00:00:00Z"
    }
  ],
  "links": {...},
  "meta": {...}
}
```

### Create Webhook

```http
POST /api/v1/webhooks
Content-Type: application/json

{
  "url": "https://example.com/webhook-receiver",
  "events": ["card.created", "card.updated", "card.expired"],
  "description": "Production webhook for card events"
}
```

Request Body:
- `url` (string, required): Endpoint that will receive webhook events
- `events` (array of strings, required): Events to subscribe to
- `description` (string, optional): Description of the webhook
- `secret` (string, optional): Secret for signing webhook payloads

Response:

```json
{
  "data": {
    "id": 2,
    "url": "https://example.com/webhook-receiver",
    "events": ["card.created", "card.updated", "card.expired"],
    "active": true,
    "secret": "whsec_1234567890abcdef",
    "created_at": "2023-04-02T15:30:45Z",
    "updated_at": "2023-04-02T15:30:45Z"
  }
}
```

## Webhook Events

| Event Name | Description |
|------------|-------------|
| `card.created` | Triggered when a new card is created |
| `card.updated` | Triggered when a card is updated |
| `card.expired` | Triggered when a card expires |
| `card.printed` | Triggered when a card is printed |
| `employee.created` | Triggered when a new employee is created |
| `employee.updated` | Triggered when an employee is updated |
| `guest.checked_in` | Triggered when a guest checks in |
| `guest.checked_out` | Triggered when a guest checks out |
| `access.granted` | Triggered when access is granted |
| `access.denied` | Triggered when access is denied |

## Webhook Payload Format

```json
{
  "id": "evt_123456789",
  "type": "card.created",
  "created_at": "2023-04-02T15:45:22Z",
  "data": {
    "id": 124,
    "card_number": "EMP-12345",
    "status": "active",
    "type": "employee",
    "issued_at": "2023-04-02T15:45:22Z",
    "expired_at": "2024-04-02T15:45:22Z",
    "employee_id": 42
  }
}
```

## API Changelog

### Version 1.0 (2023-01-01)
- Initial API release

### Version 1.1 (2023-02-15)
- Added reports endpoints
- Added filtering by department to cards endpoint
- Fixed pagination on employees endpoint

### Version 1.2 (2023-03-10)
- Added webhook functionality
- Improved error messages
- Added card printing status endpoint 
