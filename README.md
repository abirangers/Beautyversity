# Kelas Digital Beautyversity

A modern, fully functional online learning platform built with Laravel 12 using MVC architecture, relational database storage, and a responsive Tailwind CSS frontend. The platform provides course management with video integration, user authentication, and administrative capabilities.

## Features

-   User registration and authentication system with role-based access control
-   Course management with video integration (YouTube embed)
-   Payment workflow with manual verification
-   Admin panel for content management
-   Article/blog system
-   Responsive design for mobile and desktop

## Technology Stack

-   **Backend:** Laravel 12 with MVC architecture
-   **Database:** Relational database (MySQL/SQLite) with Eloquent ORM
-   **Frontend:** Blade templating with Tailwind CSS
-   **Video Hosting:** YouTube (embedded videos)
-   **Authentication:** Laravel built-in authentication with role-based access

## Installation & Setup

### Prerequisites

-   PHP 8.2+
-   Composer
-   Node.js & npm
-   MySQL or SQLite

### Installation Steps

1.  **Clone the repository:**
    ```bash
    git clone <repository-url>
    cd kelas-digital-laravel
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install --optimize-autoloader --no-dev
    ```

3. **Install JavaScript dependencies:**
    ```bash
    npm install
    ```

4.  **Set up environment file:**
    -   Copy `.env.example` to `.env`.
    -   Configure your database connection (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
    -   Configure your YouTube API key if needed.

5.  **Generate application key:**
    ```bash
    php artisan key:generate
    ```

6.  **Run database migrations and seeders:**
    ```bash
    php artisan migrate --seed
    ```

7.  **Compile and minify frontend assets for production:**
    ```bash
    npm run build
    ```

8.  **Set proper permissions:**
    ```bash
    chmod -R 755 storage
    chmod -R 755 bootstrap/cache
    ```

9. **Configure your web server** (Apache/Nginx) to point to the `public` directory.

## Deployment

For production deployment, ensure the following:

-   Set `APP_ENV=production` and `APP_DEBUG=false` in your `.env` file.
-   Run `php artisan config:cache` to cache configuration.
-   Run `php artisan route:cache` to cache routes.
-   Run `php artisan view:cache` to cache views.
-   Ensure the `storage` and `bootstrap/cache` directories are writable by the web server.
-   Use a process monitor like Supervisor to run queue workers if using queues.
-   Configure HTTPS for secure communication.

## Contributing

1.  Fork the repository.
2.  Create a new branch (`git checkout -b feature/your-feature`).
3.  Make your changes.
4.  Commit your changes (`git commit -m 'Add some feature'`).
5.  Push to the branch (`git push origin feature/your-feature`).
6.  Open a pull request.

## License

This project is licensed under the MIT License.
