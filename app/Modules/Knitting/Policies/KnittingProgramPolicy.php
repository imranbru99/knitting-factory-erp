<?php

declare(strict_types=1);

namespace App\Modules\Knitting\Policies;

use App\Models\User;
use App\Modules\Knitting\Models\KnittingProgram;
use App\Modules\Support\ModuleGate;

class KnittingProgramPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allows($user, 'view');
    }

    public function view(User $user, KnittingProgram $model): bool
    {
        return $this->allows($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->allows($user, 'create');
    }

    public function update(User $user, KnittingProgram $model): bool
    {
        return $this->allows($user, 'update');
    }

    public function delete(User $user, KnittingProgram $model): bool
    {
        return $this->allows($user, 'delete');
    }

    private function allows(User $user, string $action): bool
    {
        if (! ModuleGate::allows('knitting')) {
            return false;
        }

        return $user->is_super_admin || $user->hasPermission($action.' KnittingProgram');
    }
}
