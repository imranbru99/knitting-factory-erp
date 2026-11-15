<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Policies;

use App\Models\User;
use App\Modules\Dyeing\Models\FinishingLog;
use App\Modules\Support\ModuleGate;

class FinishingLogPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allows($user, 'view');
    }

    public function view(User $user, FinishingLog $model): bool
    {
        return $this->allows($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->allows($user, 'create');
    }

    public function update(User $user, FinishingLog $model): bool
    {
        return $this->allows($user, 'update');
    }

    public function delete(User $user, FinishingLog $model): bool
    {
        return $this->allows($user, 'delete');
    }

    private function allows(User $user, string $action): bool
    {
        if (! ModuleGate::allows('dyeing')) {
            return false;
        }

        return $user->is_super_admin || $user->hasPermission($action.' FinishingLog');
    }
}
