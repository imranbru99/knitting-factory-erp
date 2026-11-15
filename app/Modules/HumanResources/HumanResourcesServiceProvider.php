<?php

declare(strict_types=1);

namespace App\Modules\HumanResources;

use Illuminate\Support\ServiceProvider;

class HumanResourcesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }
}
