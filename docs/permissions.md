# Permissions

A permission name is `{action} {Model}`, for example `view SalesOrder` and `create YarnIssue`. The catalog is `App\Modules\Access\PermissionCatalog`. The seeder creates one row per name and attaches them to the General Manager role.

`User::hasPermission()` is true when a role on the user has that permission name. `is_super_admin` passes the gate before policies run. Policies also call `ModuleGate`. A company module row that is disabled hides that module. A missing row leaves the module available.

Field-level hides are not a separate table. A screen that must hide a rate from a role should check `hasPermission` for a dedicated permission such as `update PriceList`.
