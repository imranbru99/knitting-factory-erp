<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Policies;

use App\Models\User;
use App\Modules\Commercial\Models\Sample;
use App\Modules\Support\ModuleGate;

class SamplePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allows($user, 'view');
    }

    public function view(User $user, Sample $model): bool
    {
        return $this->allows($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->allows($user, 'create');
    }

    public function update(User $user, Sample $model): bool
    {
        return $this->allows($user, 'update');
    }

    public function delete(User $user, Sample $model): bool
    {
        return $this->allows($user, 'delete');
    }

    private function allows(User $user, string $action): bool
    {
        if (! ModuleGate::allows('commercial')) {
            return false;
        }

        return $user->is_super_admin || $user->hasPermission($action.' Sample');
    }
}
