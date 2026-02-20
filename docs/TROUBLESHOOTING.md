# Troubleshooting

## 1) UI Changes Not Showing
Symptoms:
- Old layout still appears after editing views.

Fix:
- `php artisan optimize:clear`
- Hard refresh browser (`Ctrl+F5`).

## 2) Route/View Cache Issues
Symptoms:
- Wrong route behavior or stale Blade output.

Fix:
- `php artisan optimize:clear`
- Optional rebuild:
  - `php artisan view:cache`

## 3) SMTP Not Sending
Checklist:
- Confirm `MAIL_*` values in `.env`.
- Confirm DB `settings` SMTP values (if production override is enabled).
- Confirm host, port, encryption match provider.
- Check 2FA/app-password requirements for mailbox provider.
- Clear config cache:
  - `php artisan optimize:clear`

## 4) Database Connection Fails
Checklist:
- Verify `DB_*` values in `.env`.
- Ensure MySQL service is running.
- Confirm database exists and `database.sql` imported.

## 5) Asset URL / Subfolder Issues
Symptoms:
- CSS/JS/images fail on subfolder deployments.

Fix:
- Set:
  - `APP_URL`
  - `ASSET_URL`
  - `LIVEWIRE_ASSET_URL`
  - `LIVEWIRE_APP_URL`
- Then clear cache:
  - `php artisan optimize:clear`

## 6) Permission Errors
Symptoms:
- Cache/log write failures.

Fix:
- Ensure web user can write:
  - `storage/`
  - `bootstrap/cache/`

## 7) Common Runtime Check
- Review logs:
  - `storage/logs/laravel.log`
