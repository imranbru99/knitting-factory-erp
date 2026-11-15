<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Policies;

use App\Models\User;
use App\Modules\Accounts\Models\Journal;
use App\Modules\Support\ModuleGate;

class JournalPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allows($user, 'view');
    }

    public function view(User $user, Journal $model): bool
    {
        return $this->allows($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->allows($user, 'create');
    }

    public function update(User $user, Journal $model): bool
    {
        return $this->allows($user, 'update');
    }

    public function delete(User $user, Journal $model): bool
    {
        return $this->allows($user, 'delete');
    }

    private function allows(User $user, string $action): bool
    {
        if (! ModuleGate::allows('accounts')) {
            return false;
        }

        return $user->is_super_admin || $user->hasPermission($action.' Journal');
    }
}
