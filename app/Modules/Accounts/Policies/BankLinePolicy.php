<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Policies;

use App\Models\User;
use App\Modules\Accounts\Models\BankLine;
use App\Modules\Support\ModuleGate;

class BankLinePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allows($user, 'view');
    }

    public function view(User $user, BankLine $model): bool
    {
        return $this->allows($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->allows($user, 'create');
    }

    public function update(User $user, BankLine $model): bool
    {
        return $this->allows($user, 'update');
    }

    public function delete(User $user, BankLine $model): bool
    {
        return $this->allows($user, 'delete');
    }

    private function allows(User $user, string $action): bool
    {
        if (! ModuleGate::allows('accounts')) {
            return false;
        }

        return $user->is_super_admin || $user->hasPermission($action.' BankLine');
    }
}
