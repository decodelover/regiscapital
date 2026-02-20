# Regis Capital Bank

Regis Capital Bank is a Laravel-based digital banking web application with user and admin portals for account management, deposits, transfers, KYC, and virtual card operations.

## Core Features
- iOS-inspired responsive user dashboard for mobile and desktop.
- KYC flow with status tracking and admin review.
- Deposit channels: bank transfer, Bitcoin, Ethereum, and USDT (admin configurable).
- Virtual card request workflow (apply, review, approve/reject, activate/deactivate/block).
- Transaction history, withdrawals, transfer flows, profile/security, notifications, and support views.
- Admin controls for users, KYC, card management, settings, and payment integrations.

## Tech Stack
- PHP `^7.3|^8.0`
- Laravel `^8.12`
- MySQL/MariaDB
- Tailwind CSS + Alpine.js
- Laravel Mix (Webpack)

## Project Structure
- `app/` application logic (controllers, models, middleware, providers)
- `resources/views/` Blade templates (user/admin/auth)
- `routes/` route definitions (`user.php`, `admin.php`, etc.)
- `config/` application and service configuration
- `database.sql` SQL dump for initial data
- `docs/` deployment and operations documentation

## Quick Start (Local)
1. Clone the repository.
2. Install PHP dependencies:
   - `composer install`
3. Install frontend dependencies:
   - `npm install`
4. Create environment file:
   - `copy .env.example .env` (Windows)
   - `cp .env.example .env` (Linux/macOS)
5. Generate application key:
   - `php artisan key:generate`
6. Configure database credentials in `.env`.
7. Import `database.sql` into your database.
8. Build frontend assets:
   - `npm run dev` (development)
   - `npm run prod` (production)
9. Clear cache:
   - `php artisan optimize:clear`
10. Run the app:
   - XAMPP/Apache: place project in `htdocs` and open via browser.
   - Artisan server: `php artisan serve`

Detailed setup instructions: `docs/INSTALLATION.md`

## Configuration Notes
- Mail settings can come from:
  - `.env` (`MAIL_*`)
  - Database `settings` row (`smtp_*`, `emailfrom`, etc.) in production via `app/Providers/SettingsServiceProvider.php`
- If config values change, run:
  - `php artisan optimize:clear`

Detailed configuration guide: `docs/CONFIGURATION.md`

## Deployment
Production deployment checklist is documented in:
- `docs/DEPLOYMENT.md`

## Troubleshooting
Common issues (cache, SMTP, route/view staleness, permissions) are documented in:
- `docs/TROUBLESHOOTING.md`

## Security
- Do not commit `.env`, private keys, or real credentials.
- Rotate all credentials immediately if they are ever exposed.
- Change default/admin credentials after first deployment.

## Repository Hygiene
- Runtime files (logs/cache/vendor/node_modules) are excluded through `.gitignore`.
- Keep secrets in environment variables and secure secret managers, not in source files.

## License
This repository contains application code and third-party dependencies under their respective licenses.
