<?php

declare(strict_types=1);

namespace App\Modules\Commercial;

use Illuminate\Support\ServiceProvider;

class CommercialServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }
}
