<?php

declare(strict_types=1);

namespace App\Modules\Maintenance\Policies;

use App\Models\User;
use App\Modules\Maintenance\Models\SparePart;
use App\Modules\Support\ModuleGate;

class SparePartPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allows($user, 'view');
    }

    public function view(User $user, SparePart $model): bool
    {
        return $this->allows($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->allows($user, 'create');
    }

    public function update(User $user, SparePart $model): bool
    {
        return $this->allows($user, 'update');
    }

    public function delete(User $user, SparePart $model): bool
    {
        return $this->allows($user, 'delete');
    }

    private function allows(User $user, string $action): bool
    {
        if (! ModuleGate::allows('maintenance')) {
            return false;
        }

        return $user->is_super_admin || $user->hasPermission($action.' SparePart');
    }
}
