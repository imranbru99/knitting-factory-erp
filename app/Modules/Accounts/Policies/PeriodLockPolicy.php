<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Policies;

use App\Models\User;
use App\Modules\Accounts\Models\PeriodLock;
use App\Modules\Support\ModuleGate;

class PeriodLockPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allows($user, 'view');
    }

    public function view(User $user, PeriodLock $model): bool
    {
        return $this->allows($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->allows($user, 'create');
    }

    public function update(User $user, PeriodLock $model): bool
    {
        return $this->allows($user, 'update');
    }

    public function delete(User $user, PeriodLock $model): bool
    {
        return $this->allows($user, 'delete');
    }

    private function allows(User $user, string $action): bool
    {
        if (! ModuleGate::allows('accounts')) {
            return false;
        }

        return $user->is_super_admin || $user->hasPermission($action.' PeriodLock');
    }
}
