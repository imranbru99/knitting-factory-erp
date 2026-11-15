<?php

declare(strict_types=1);

namespace App\Modules\HumanResources\Policies;

use App\Models\User;
use App\Modules\HumanResources\Models\PayslipLine;
use App\Modules\Support\ModuleGate;

class PayslipLinePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allows($user, 'view');
    }

    public function view(User $user, PayslipLine $model): bool
    {
        return $this->allows($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->allows($user, 'create');
    }

    public function update(User $user, PayslipLine $model): bool
    {
        return $this->allows($user, 'update');
    }

    public function delete(User $user, PayslipLine $model): bool
    {
        return $this->allows($user, 'delete');
    }

    private function allows(User $user, string $action): bool
    {
        if (! ModuleGate::allows('humanresources')) {
            return false;
        }

        return $user->is_super_admin || $user->hasPermission($action.' PayslipLine');
    }
}
