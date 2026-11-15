<?php

declare(strict_types=1);

namespace App\Modules\Quality\Policies;

use App\Models\User;
use App\Modules\Quality\Models\FinishedInspectionDefect;
use App\Modules\Support\ModuleGate;

class FinishedInspectionDefectPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allows($user, 'view');
    }

    public function view(User $user, FinishedInspectionDefect $model): bool
    {
        return $this->allows($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->allows($user, 'create');
    }

    public function update(User $user, FinishedInspectionDefect $model): bool
    {
        return $this->allows($user, 'update');
    }

    public function delete(User $user, FinishedInspectionDefect $model): bool
    {
        return $this->allows($user, 'delete');
    }

    private function allows(User $user, string $action): bool
    {
        if (! ModuleGate::allows('quality')) {
            return false;
        }

        return $user->is_super_admin || $user->hasPermission($action.' FinishedInspectionDefect');
    }
}
