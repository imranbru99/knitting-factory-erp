# Package gaps

`imrandevbd/adhikar` is not on Packagist. Roles and permissions are stored in `roles`, `permissions`, `permission_role`, and `role_user`. Permission names follow the filament-master template (`view Party`). Spatie Permission is not installed.

`imrandevbd/tarikh` publishes `Tarikh\Laravel\TarikhServiceProvider`, and that class is not in the package. Discovery is disabled. The class has no Bangla calendar, so `App\Modules\Support\BanglaCalendar` adds the calendar and Bangla digits through `Tarikh::macro`.

`imrandevbd/laravel-filament-master` references Filament v3 form and command classes. Loading the provider stops Artisan on Filament v4, so the provider is not discovered. Master screens are normal Filament v4 resources.

`imrandevbd/laravel-admin-panel` builds its own panel and defaults the prefix to `admin`, which collides with Filament. The ERP panel stays Filament at `/admin`. The vendor shell is mounted at `/vendor-shell`.

`imrandevbd/laravel-attendance-hub` Filament resources use the Filament v3 `Form` class. The hub facade and device tables are used; the plugin is not registered.

`imrandevbd/drutogoti` writes profiler rows when enabled, and its migrations are stubs that are not loaded automatically. Leave `DRUTOGOTI_ENABLED=false` until those tables exist.

`imrandevbd/laravel-ai-ocr` does not auto-load its migration. Publish or copy it before `ai-ocr.store.enabled` is turned on.
