<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Policies;

use App\Models\User;
use App\Modules\Inventory\Models\YarnReturn;
use App\Modules\Support\ModuleGate;

class YarnReturnPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allows($user, 'view');
    }

    public function view(User $user, YarnReturn $model): bool
    {
        return $this->allows($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->allows($user, 'create');
    }

    public function update(User $user, YarnReturn $model): bool
    {
        return $this->allows($user, 'update');
    }

    public function delete(User $user, YarnReturn $model): bool
    {
        return $this->allows($user, 'delete');
    }

    private function allows(User $user, string $action): bool
    {
        if (! ModuleGate::allows('inventory')) {
            return false;
        }

        return $user->is_super_admin || $user->hasPermission($action.' YarnReturn');
    }
}
