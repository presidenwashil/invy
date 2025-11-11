# Invy

Invy is a web application for managing inventory, built with Laravel and Filament.

## Table of Contents

- [Features](#features)
- [Installation](#installation)

## Features

- **Category Management**: Create, edit, and delete categories.
- **Item Management**: Create, edit, and delete items. Assign items to categories and units.
- **Supplier Management**: Manage suppliers and their associated items.
- **Warehouse Management**: Manage warehouses and their associated items.
- **Transaction Management**: Record transactions for items, including reference numbers.
- **User Management**: Manage users and their roles.

### Detailed Explanation of Each Feature

- **Category Management**: Allows you to organize items into categories for better management.
- **Item Management**: Provides functionality to manage items, including assigning them to categories and units, and setting their stock and price.
- **Supplier Management**: Enables you to manage suppliers and associate them with items.
- **Warehouse Management**: Allows you to manage warehouses and track the quantity of items in each warehouse.
- **Transaction Management**: Records transactions for items, including generating unique reference numbers for each transaction.
- **User Management**: Provides functionality to manage users and their roles within the application.

## Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js and npm

### Steps to Install

1. Clone the repository:
   ```sh
   git clone https://github.com/presidenwashil/invy.git
   cd invy
   ```

2. Copy the example environment file and configure the environment variables:
   ```sh
   cp .env.example .env
   ```

3. Create db first, if using sqlite do this:
   ```sh
   touch database/database.sqlite
   ```

4. Install dependencies:
   ```sh
   composer install
   npm install
   ```

5. Generate an application key:
   ```sh
   php artisan key:generate
   ```

6. Run the database migrations:
   ```sh
   php artisan migrate:fresh --seed
   ```

7. Give the first user after seeding permission as super admin:
   ```sh
   php artisan shield:super-admin
   ```

8. Start the development server:
   ```sh
   composer run dev
   ```