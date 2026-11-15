# Deployment

Local development uses SQLite (`database/database.sqlite`). Tests use SQLite in memory. Production should use MySQL 8 and Redis.

## Environment

Copy `.env.example`. Set `APP_URL`, `DB_*` for MySQL, `CACHE_STORE=redis`, `QUEUE_CONNECTION=redis`, and `SESSION_DRIVER=redis` when Redis is available. Keep `DRUTOGOTI_ENABLED=false` until its tables are migrated. Keep `ADMIN_PANEL_PREFIX=vendor-shell`. Set `AI_HUB_ENABLED` only after a provider key exists.

## FastPanel / nginx

Point the site root at `public/`. PHP 8.3 or newer with `bcmath`, `intl`, `mbstring`, `pdo_mysql`, `redis`, and `zip`. Run:

```
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Run a queue worker, or Horizon after `php artisan horizon:install` and a supervisor program for `php artisan horizon`. Reverb can be enabled when the floor screens need live idle time: `php artisan reverb:start`.

Schedule `php artisan schedule:run` every minute for SLA escalation and the daily issue digest.

## Demo login

After seeding: `admin@gazipurknit.test` / `password`. Change the password before the site is public.

## Backup

Dump MySQL daily and keep `storage/app`. Restore onto a copy and run `php artisan migrate --pretend` before promoting it.
