<?php

declare(strict_types=1);

namespace App\Modules\Knitting;

use Illuminate\Support\ServiceProvider;

class KnittingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }
}
