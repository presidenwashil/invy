# Invy

Invy is a web application for managing inventory, built with Laravel and Filament.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

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

2. Install dependencies:
   ```sh
   composer install
   npm install
   ```

3. Copy the example environment file and configure the environment variables:
   ```sh
   cp .env.example .env
   ```

4. Generate an application key:
   ```sh
   php artisan key:generate
   ```

5. Run the database migrations:
   ```sh
   php artisan migrate
   ```

6. Start the development server:
   ```sh
   npm run dev
   ```

### Troubleshooting

- If you encounter any issues during installation, please refer to the [Laravel documentation](https://laravel.com/docs) or open an issue on the GitHub repository.

## Configuration

### Environment Variables

The application uses the following environment variables:

- `APP_NAME`: The name of the application.
- `APP_ENV`: The application environment (e.g., local, production).
- `APP_KEY`: The application key.
- `APP_DEBUG`: Enable or disable debug mode.
- `APP_URL`: The application URL.
- `DB_CONNECTION`: The database connection type (e.g., sqlite, mysql).
- `DB_HOST`: The database host.
- `DB_PORT`: The database port.
- `DB_DATABASE`: The database name.
- `DB_USERNAME`: The database username.
- `DB_PASSWORD`: The database password.

### Configuration Files

The configuration files are located in the `config` directory. You can modify these files to customize the application settings.

### Advanced Configuration Options

For advanced configuration options, please refer to the [Laravel documentation](https://laravel.com/docs).

## Usage

### Running the Application

To run the application, use the following command:
```sh
npm run dev
```

### Common Commands

- `php artisan serve`: Start the Laravel development server.
- `php artisan migrate`: Run the database migrations.
- `php artisan tinker`: Open the Laravel Tinker console.

### Examples

- To create a new category, navigate to the Categories section in the admin panel and click "Create Category".
- To add a new item, navigate to the Items section in the admin panel and click "Create Item".

## Contributing

### How to Contribute

We welcome contributions to the project! To contribute, please follow these steps:

1. Fork the repository.
2. Create a new branch for your feature or bugfix.
3. Make your changes and commit them with descriptive commit messages.
4. Push your changes to your forked repository.
5. Open a pull request to the main repository.

### Code of Conduct

Please review and abide by our [Code of Conduct](CODE_OF_CONDUCT.md) to ensure a welcoming community for all.

### Contribution Guidelines

- Follow the coding standards and best practices.
- Write tests for your changes.
- Update the documentation if necessary.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more information.

### Third-Party Licenses

This project uses third-party libraries and components. Please refer to their respective licenses for more information.

## Creating a User for Accessing the Panel

To create a user for accessing the Filament admin panel, follow these steps:

1. Open your terminal and navigate to the project directory.

2. Run the following command to create a new user:
   ```sh
   php artisan make:filament-user
   ```

3. Follow the prompts to enter the user's name, email, and password.

4. The user will be created and can now access the Filament admin panel by navigating to the `/admin` URL in your browser and logging in with the provided credentials.
