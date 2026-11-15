<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Policies;

use App\Models\User;
use App\Modules\Delivery\Models\Vehicle;
use App\Modules\Support\ModuleGate;

class VehiclePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allows($user, 'view');
    }

    public function view(User $user, Vehicle $model): bool
    {
        return $this->allows($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->allows($user, 'create');
    }

    public function update(User $user, Vehicle $model): bool
    {
        return $this->allows($user, 'update');
    }

    public function delete(User $user, Vehicle $model): bool
    {
        return $this->allows($user, 'delete');
    }

    private function allows(User $user, string $action): bool
    {
        if (! ModuleGate::allows('delivery')) {
            return false;
        }

        return $user->is_super_admin || $user->hasPermission($action.' Vehicle');
    }
}
