# Defense8 System Documentation

## Overview
Defense8 is a comprehensive Laravel-based application that provides a modular system for card management, employee management, guest management, reporting, and more. The system is built on Laravel with Nova admin panel integration, and incorporates real-time features, multiple authentication types, and custom packages.

## System Components
The system is organized into several key components:

1. **Core Application** - The base Laravel application that provides the foundation
2. **Nova Admin Panel** - Administrative interface for managing system resources
3. **Custom Packages** - Specialized functionality modules in the `package/sq/` directory
4. **Modules** - Reusable components in the `modules/` directory
5. **Nova Components** - Custom components for the Nova admin panel

## Documentation Structure
This documentation is divided into the following sections:

1. [Architecture](architecture.md) - System architecture, design patterns, and technology stack
2. [Installation](installation.md) - Setup, requirements, and configuration
3. [Features](features.md) - Detailed explanations of system features
4. [API Reference](api-reference.md) - API endpoints, parameters, and responses
5. [Authentication](authentication.md) - Authentication mechanisms and security
6. [Packages](packages.md) - Documentation for custom packages
7. [Modules](modules.md) - Documentation for core modules
8. [Database](database.md) - Database schema, relationships, and models
9. [Development Guide](development-guide.md) - Guidelines for developers working on the system
10. [Deployment](deployment.md) - Deployment strategies and environments

## Technology Stack
- PHP 8.2+
- Laravel 10.x
- Vue.js 3.x
- Laravel Nova
- Inertia.js
- Livewire
- TailwindCSS
- PostgreSQL/MySQL
- Redis for caching and queues
- Laravel Reverb for WebSockets

## License
This project is licensed under the MIT License. 