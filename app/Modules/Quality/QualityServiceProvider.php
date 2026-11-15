<?php

declare(strict_types=1);

namespace App\Modules\Quality;

use Illuminate\Support\ServiceProvider;

class QualityServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }
}
