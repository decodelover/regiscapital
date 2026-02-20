# Configuration Guide

## Environment File
Create `.env` from `.env.example` and configure at minimum:

- `APP_NAME`
- `APP_ENV`
- `APP_URL`
- `APP_KEY`
- `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_ENCRYPTION`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME`

## App URL and Asset URL
When hosted in a subfolder, make sure URLs match your public path:
- `APP_URL=http://localhost/regisbank`
- `ASSET_URL=http://localhost/regisbank`
- `LIVEWIRE_ASSET_URL=http://localhost/regisbank`
- `LIVEWIRE_APP_URL=http://localhost/regisbank`

## Mail Configuration
This project can read mail credentials from:
1. `.env` (`MAIL_*`)
2. Database `settings` table (`smtp_host`, `smtp_port`, `smtp_encrypt`, `smtp_user`, `smtp_password`, `emailfrom`, `emailfromname`)

In production, `app/Providers/SettingsServiceProvider.php` can override SMTP using DB settings.

After any mail update:
- `php artisan optimize:clear`

## Payments and Optional Integrations
Depending on enabled features, configure:
- Paystack keys
- Flutterwave keys
- BitPay credentials
- Twilio credentials
- Google/Facebook social login keys
- Telegram bot token

## Branding
Shared logo path is managed in app providers/views.  
If branding changes, clear cache:
- `php artisan optimize:clear`

## Security Practices
- Never commit `.env`.
- Rotate credentials if exposed.
- Do not store production secrets in public SQL dumps.
