<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\Filament\AdminPanelProvider::class,
    App\Modules\Core\CoreServiceProvider::class,
    App\Modules\Masters\MastersServiceProvider::class,
    App\Modules\Commercial\CommercialServiceProvider::class,
    App\Modules\Procurement\ProcurementServiceProvider::class,
    App\Modules\Inventory\InventoryServiceProvider::class,
    App\Modules\Knitting\KnittingServiceProvider::class,
    App\Modules\Dyeing\DyeingServiceProvider::class,
    App\Modules\Quality\QualityServiceProvider::class,
    App\Modules\Delivery\DeliveryServiceProvider::class,
    App\Modules\Waste\WasteServiceProvider::class,
    App\Modules\Maintenance\MaintenanceServiceProvider::class,
    App\Modules\HumanResources\HumanResourcesServiceProvider::class,
    App\Modules\Accounts\AccountsServiceProvider::class,
    App\Modules\Operations\OperationsServiceProvider::class,
    App\Modules\Website\WebsiteServiceProvider::class,
];
