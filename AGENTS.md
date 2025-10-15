# Repository Guidelines

## Project Structure & Module Organization
- Laravel 12 (MVC).
- Code: `app/Http/Controllers`, `app/Models`, `app/Console/Commands` (WordPress migration).
- Views: `resources/views` (`layouts`, `article/`, `course/`, `admin/`, `auth/`).
- Routes: `routes/web.php`.
- Database: `database/migrations`, `database/seeders`.
- Assets: `public/` (served), Vite outputs; storage via `storage/`.
- Tests: `tests/Feature`, `tests/Unit`.
- Context docs: `.kilocode/rules/memory-bank`.

## Build, Test, and Development Commands
- `composer install` — install PHP deps.
- `cp .env.example .env && php artisan key:generate` — bootstrap app key.
- `php artisan migrate --seed` — schema + seed data.
- `npm install && npm run dev` (or `npm run build`) — Vite assets.
- `php artisan serve` — run locally.
- `php artisan test` — run PHPUnit tests.
- `php artisan storage:link` — expose media storage.
- `php artisan list` — discover WordPress migration commands (see `app/Console/Commands`).

## Coding Style & Naming Conventions
- PHP: PSR-12, 4-space indent. Classes `PascalCase`, methods `camelCase`.
- Eloquent models singular `PascalCase`; tables plural `snake_case`.
- Controllers suffixed `Controller`; Blade views `kebab-case`.
- Route names dotted (e.g., `articles.show`).

## Testing Guidelines
- Framework: PHPUnit via `php artisan test`.
- Place tests under `tests/Feature` or `tests/Unit`; name `*Test.php`.
- Prefer `RefreshDatabase`, model factories/seeders for DB tests.
- Cover critical flows: auth, enrollments, lessons, article rendering (WP blocks).

## Commit & Pull Request Guidelines
- Use Conventional Commits (`feat:`, `fix:`, `docs:`, `style:`) — matches git history.
- PRs include: clear description, linked issues, screenshots for UI, migration notes, and test evidence.

## Security & Configuration Tips
- Keep secrets in `.env`; never commit keys. Move any API keys from `.kilocode/mcp.json` to env and rotate if exposed.
- Production: `php artisan config:cache` and `route:cache`; validate requests, enforce RBAC policies; run `storage:link` for media.

## Agent-Specific Instructions
- Read `.kilocode/rules/memory-bank/*` at task start; update `context.md` after significant changes when requested.

