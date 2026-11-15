<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use App\Modules\Support\BanglaCalendar;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        BanglaCalendar::registerMacros();

        Gate::before(function (User $user): ?bool {
            return $user->is_super_admin ? true : null;
        });
    }
}
