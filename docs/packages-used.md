# Packages used

| Package | Where it is used |
|---|---|
| `imrandevbd/laravel-ai-hub` | Installed for AI calls. App code must go through `AIHub`. No direct provider SDK is called. AI features stay off until `AI_HUB_ENABLED` is set. |
| `imrandevbd/laravel-ai-ocr` | Installed for challan and test-report scans. The OCR tables are not auto-loaded by the package; enable them before turning storage on. |
| `imrandevbd/laravel-ai-catalog` | Installed. Catalog generations use `AiCatalog` when a merchandiser asks the panel to fill a fabric. |
| `imrandevbd/laravel-unicode-pdf` | Installed for challan, invoice, roll tag, and payslip output through `UnicodePdf`. |
| `imrandevbd/laravel-attendance-hub` | Installed. Device and punch tables migrate with the app. HR screens call `AttendanceHub` rather than a device SDK. The package's Filament resources target Filament v3, so they are not registered on this Filament v4 panel. |
| `imrandevbd/laravel-universal-slug` | `CmsPage`, `CmsPost`, `CatalogProduct`, and `JobPosting` use `HasUniversalSlug`. `slug_histories` is created by the website migration. |
| `imrandevbd/drutogoti` | Installed. `DRUTOGOTI_ENABLED` stays false until the package's stub tables are copied into `database/migrations` and migrated. |
| `imrandevbd/laravel-admin-panel` | Installed as a separate shell. `ADMIN_PANEL_PREFIX=vendor-shell` so it does not take `/admin` from Filament. |
| `imrandevbd/tarikh` | `Tarikh\Tarikh` is called from `BanglaCalendar`, which adds `toBangla` and `banglaDigits` macros. The package is not auto-discovered. |
| `imrandevbd/laravel-filament-master` | Installed and not auto-discovered. Its resource generator targets Filament v3. |
| `spatie/laravel-activitylog` | Every `ErpModel` and ledger row writes an activity log. Adhikar is not published, so this package covers audit only, not permissions. |
| `laravel/horizon`, `laravel/reverb`, `laravel/sanctum` | Installed for queues, realtime, and API tokens. |
| `openspout/openspout` | Excel export. `maatwebsite/excel` does not install on PHP 8.5. |
| `pragmarx/google2fa` | Staff 2FA secrets on the user record. |
| `chillerlan/php-qrcode` | Present through the Filament 2FA stack for roll and gate QR tags. |
