<?php

declare(strict_types=1);

namespace App\Modules\Website\Policies;

use App\Models\User;
use App\Modules\Website\Models\CmsMenuItem;
use App\Modules\Support\ModuleGate;

class CmsMenuItemPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allows($user, 'view');
    }

    public function view(User $user, CmsMenuItem $model): bool
    {
        return $this->allows($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->allows($user, 'create');
    }

    public function update(User $user, CmsMenuItem $model): bool
    {
        return $this->allows($user, 'update');
    }

    public function delete(User $user, CmsMenuItem $model): bool
    {
        return $this->allows($user, 'delete');
    }

    private function allows(User $user, string $action): bool
    {
        if (! ModuleGate::allows('website')) {
            return false;
        }

        return $user->is_super_admin || $user->hasPermission($action.' CmsMenuItem');
    }
}
