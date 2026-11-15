<?php

declare(strict_types=1);

namespace App\Modules\Core\Policies;

use App\Models\User;
use App\Modules\Core\Models\Permission;
use App\Modules\Support\ModuleGate;

class PermissionPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allows($user, 'view');
    }

    public function view(User $user, Permission $model): bool
    {
        return $this->allows($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->allows($user, 'create');
    }

    public function update(User $user, Permission $model): bool
    {
        return $this->allows($user, 'update');
    }

    public function delete(User $user, Permission $model): bool
    {
        return $this->allows($user, 'delete');
    }

    private function allows(User $user, string $action): bool
    {
        if (! ModuleGate::allows('core')) {
            return false;
        }

        return $user->is_super_admin || $user->hasPermission($action.' Permission');
    }
}
