# HTTP surface

Public pages are server-rendered: `/`, `/fabrics`, `/quote`, `/career`, `/process`, `/quality`, `/capacity`, `/about`, `/contact`, `/faq`, `/sitemap.xml`, `/robots.txt`, `/health`.

`POST /quote` creates an inquiry on the Gazipur Knit company and a form submission. `POST /career` creates a job application. Both routes are throttled. A filled `company_website` field is rejected.

`/floor` is the tablet page. It keeps unsynced rolls in `localStorage` and registers `/sw.js`.

`GET /reports/{report}.xlsx` requires a staff session. Report names include `yarn-stock`, `rolls`, `invoices`, `journals`, and `issues`.

Staff sign in at `/admin`. The buyer and supplier portal is the Filament panel check on `users.portal`. Sanctum is installed for tokens on the user model.

`GET /up` is the framework health check. `GET /health` also pings the database.
