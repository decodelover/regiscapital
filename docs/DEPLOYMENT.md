# Deployment Guide

## Server Requirements
- PHP 8.0+ with required extensions (`openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`)
- MySQL/MariaDB
- Composer
- Node.js/npm (for compiling assets)
- Apache or Nginx

## Production Deployment Steps
1. Upload/clone repository to server.
2. Install dependencies:
   - `composer install --no-dev --optimize-autoloader`
3. Create `.env` and set production values.
4. Generate key if missing:
   - `php artisan key:generate --force`
5. Configure DB and import `database.sql` (or run your migration strategy).
6. Build assets:
   - `npm ci`
   - `npm run prod`
7. Set folder permissions:
   - `storage/`
   - `bootstrap/cache/`
8. Cache and optimize:
   - `php artisan config:cache`
   - `php artisan route:cache`
   - `php artisan view:cache`

## Queue and Scheduler (if enabled)
- Queue worker:
  - `php artisan queue:work --tries=3 --timeout=120`
- Scheduler cron:
  - `* * * * * php /path/to/project/artisan schedule:run >> /dev/null 2>&1`

## Post-Deploy Validation
- Login (user/admin)
- Deposit methods visible and selectable
- Card request flow works end-to-end
- SMTP sends outbound mail
- No critical errors in `storage/logs/laravel.log`

## Rollback Strategy
- Keep previous release snapshot.
- Restore previous `.env`.
- Point web root/symlink back to previous release.
- Run `php artisan optimize:clear` after rollback.
