<?php

declare(strict_types=1);

namespace App\Modules\Dyeing;

use Illuminate\Support\ServiceProvider;

class DyeingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }
}
