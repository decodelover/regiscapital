# Installation Guide

This project supports local development with XAMPP/WAMP/Laragon or a standard Linux/Nginx/Apache stack.

## Prerequisites
- PHP 8.0+ (recommended)
- Composer
- Node.js and npm
- MySQL or MariaDB
- Web server (Apache/Nginx)

## Option A: XAMPP (Windows)
1. Copy project into `C:\xampp\htdocs\regisbank`.
2. Start Apache and MySQL from XAMPP Control Panel.
3. Create a database (example: `regisbank_db`) using phpMyAdmin.
4. Import `database.sql`.
5. Install dependencies:
   - `composer install`
   - `npm install`
6. Create env file:
   - `copy .env.example .env`
7. Configure `.env`:
   - `APP_URL=http://localhost/regisbank`
   - Database credentials (`DB_*`)
8. Generate app key:
   - `php artisan key:generate`
9. Build assets:
   - `npm run dev`
10. Clear caches:
   - `php artisan optimize:clear`
11. Open:
   - `http://localhost/regisbank`

## Option B: Artisan Local Server
1. Follow steps 3-10 above.
2. Run:
   - `php artisan serve`
3. Open:
   - `http://127.0.0.1:8000`

## Post-Install Checklist
- Change admin credentials immediately.
- Confirm SMTP works with a test email.
- Verify file permissions for `storage/` and `bootstrap/cache/`.
- Clear cache after any env or config change:
  - `php artisan optimize:clear`
