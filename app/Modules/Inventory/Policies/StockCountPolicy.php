<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Policies;

use App\Models\User;
use App\Modules\Inventory\Models\StockCount;
use App\Modules\Support\ModuleGate;

class StockCountPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allows($user, 'view');
    }

    public function view(User $user, StockCount $model): bool
    {
        return $this->allows($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->allows($user, 'create');
    }

    public function update(User $user, StockCount $model): bool
    {
        return $this->allows($user, 'update');
    }

    public function delete(User $user, StockCount $model): bool
    {
        return $this->allows($user, 'delete');
    }

    private function allows(User $user, string $action): bool
    {
        if (! ModuleGate::allows('inventory')) {
            return false;
        }

        return $user->is_super_admin || $user->hasPermission($action.' StockCount');
    }
}
