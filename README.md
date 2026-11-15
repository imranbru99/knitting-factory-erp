# Gazipur Knit

Knitting-factory ERP and public site. Laravel 12, Filament 4, SQLite for local work, MySQL 8 and Redis for production.

Staff panel: `/admin`  
After `php artisan db:seed`: `admin@gazipurknit.test` / `password`

The seeder posts one order from yarn receipt through buyer collection. Yarn, grey, and finished stock finish at zero, and the journals balance.

```
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan db:seed
php artisan serve
```

Tests: `./vendor/bin/pest`

Docs: `docs/architecture.md`, `docs/modules.md`, `docs/permissions.md`, `docs/automation-rules.md`, `docs/api.md`, `docs/deployment-fastpanel.md`, `docs/packages-used.md`, `docs/package-gaps.md`.
