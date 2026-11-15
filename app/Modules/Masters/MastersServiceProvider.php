<?php

declare(strict_types=1);

namespace App\Modules\Masters;

use Illuminate\Support\ServiceProvider;

class MastersServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }
}
