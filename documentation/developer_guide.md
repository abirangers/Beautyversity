# Developer Guide: Kelas Digital Beautyversity

This guide provides instructions for setting up and developing the Kelas Digital Beautyversity platform.

## 1. Project Setup

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm
- MySQL or SQLite

### Installation Steps
1.  **Clone the repository:**
    ```bash
    git clone <repository-url>
    cd kelas-digital-laravel
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Install JavaScript dependencies:**
    ```bash
    npm install
    ```

4.  **Set up environment file:**
    - Copy `.env.example` to `.env`.
    - Configure your database connection (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

5.  **Generate application key:**
    ```bash
    php artisan key:generate
    ```

6.  **Run database migrations and seeders:**
    ```bash
    php artisan migrate --seed
    ```

7.  **Compile frontend assets:**
    ```bash
    npm run dev
    ```

8.  **Start the development server:**
    ```bash
    php artisan serve
    ```

## 2. System Architecture
The application is built on Laravel 12 using the MVC (Model-View-Controller) pattern.

-   **Models:** Located in `app/Models`, they interact with the database using Eloquent ORM.
-   **Views:** Located in `resources/views`, they are Blade templates responsible for the UI.
-   **Controllers:** Located in `app/Http/Controllers`, they handle user requests and business logic.
-   **Routes:** Defined in `routes/web.php`, they map URLs to controller actions.

## 3. Key Development Concepts

-   **Authentication:** Handled by Laravel's built-in authentication system. User roles (`admin`, `student`) are managed via the `role` column in the `users` table.
-   **Admin Panel:** Accessible at the `/admin` prefix. Routes are protected by the `auth` and `admin` middleware.
-   **Database Migrations:** Schema changes are managed through migration files in `database/migrations`.
-   **Frontend:** Styling is done with Tailwind CSS. The configuration can be found in `tailwind.config.js`. Assets are compiled using Vite.
