<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Policies;

use App\Models\User;
use App\Modules\Procurement\Models\RequisitionLine;
use App\Modules\Support\ModuleGate;

class RequisitionLinePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allows($user, 'view');
    }

    public function view(User $user, RequisitionLine $model): bool
    {
        return $this->allows($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->allows($user, 'create');
    }

    public function update(User $user, RequisitionLine $model): bool
    {
        return $this->allows($user, 'update');
    }

    public function delete(User $user, RequisitionLine $model): bool
    {
        return $this->allows($user, 'delete');
    }

    private function allows(User $user, string $action): bool
    {
        if (! ModuleGate::allows('procurement')) {
            return false;
        }

        return $user->is_super_admin || $user->hasPermission($action.' RequisitionLine');
    }
}
