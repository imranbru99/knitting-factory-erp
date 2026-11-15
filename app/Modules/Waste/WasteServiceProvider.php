<?php

declare(strict_types=1);

namespace App\Modules\Waste;

use Illuminate\Support\ServiceProvider;

class WasteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }
}
