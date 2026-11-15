<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Policies;

use App\Models\User;
use App\Modules\Knitting\Models\Roll;
use App\Modules\Support\ModuleGate;

class RollPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allows($user, 'view');
    }

    public function view(User $user, Roll $model): bool
    {
        return $this->allows($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->allows($user, 'create');
    }

    public function update(User $user, Roll $model): bool
    {
        return $this->allows($user, 'update');
    }

    public function delete(User $user, Roll $model): bool
    {
        return $this->allows($user, 'delete');
    }

    private function allows(User $user, string $action): bool
    {
        if (! ModuleGate::allows('knitting')) {
            return false;
        }

        return $user->is_super_admin || $user->hasPermission($action.' Roll');
    }
}
