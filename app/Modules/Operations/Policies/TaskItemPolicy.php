<?php

declare(strict_types=1);

namespace App\Modules\Operations\Policies;

use App\Models\User;
use App\Modules\Operations\Models\TaskItem;
use App\Modules\Support\ModuleGate;

class TaskItemPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allows($user, 'view');
    }

    public function view(User $user, TaskItem $model): bool
    {
        return $this->allows($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->allows($user, 'create');
    }

    public function update(User $user, TaskItem $model): bool
    {
        return $this->allows($user, 'update');
    }

    public function delete(User $user, TaskItem $model): bool
    {
        return $this->allows($user, 'delete');
    }

    private function allows(User $user, string $action): bool
    {
        if (! ModuleGate::allows('operations')) {
            return false;
        }

        return $user->is_super_admin || $user->hasPermission($action.' TaskItem');
    }
}
