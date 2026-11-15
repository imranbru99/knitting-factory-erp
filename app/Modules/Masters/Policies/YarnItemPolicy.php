<?php

declare(strict_types=1);

namespace App\Modules\Masters\Policies;

use App\Models\User;
use App\Modules\Masters\Models\YarnItem;
use App\Modules\Support\ModuleGate;

class YarnItemPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allows($user, 'view');
    }

    public function view(User $user, YarnItem $model): bool
    {
        return $this->allows($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->allows($user, 'create');
    }

    public function update(User $user, YarnItem $model): bool
    {
        return $this->allows($user, 'update');
    }

    public function delete(User $user, YarnItem $model): bool
    {
        return $this->allows($user, 'delete');
    }

    private function allows(User $user, string $action): bool
    {
        if (! ModuleGate::allows('masters')) {
            return false;
        }

        return $user->is_super_admin || $user->hasPermission($action.' YarnItem');
    }
}
