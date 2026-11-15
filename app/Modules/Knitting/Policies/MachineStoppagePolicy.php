<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Policies;

use App\Models\User;
use App\Modules\Knitting\Models\MachineStoppage;
use App\Modules\Support\ModuleGate;

class MachineStoppagePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allows($user, 'view');
    }

    public function view(User $user, MachineStoppage $model): bool
    {
        return $this->allows($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->allows($user, 'create');
    }

    public function update(User $user, MachineStoppage $model): bool
    {
        return $this->allows($user, 'update');
    }

    public function delete(User $user, MachineStoppage $model): bool
    {
        return $this->allows($user, 'delete');
    }

    private function allows(User $user, string $action): bool
    {
        if (! ModuleGate::allows('knitting')) {
            return false;
        }

        return $user->is_super_admin || $user->hasPermission($action.' MachineStoppage');
    }
}
