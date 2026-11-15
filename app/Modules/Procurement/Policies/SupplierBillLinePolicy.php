<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Policies;

use App\Models\User;
use App\Modules\Procurement\Models\SupplierBillLine;
use App\Modules\Support\ModuleGate;

class SupplierBillLinePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allows($user, 'view');
    }

    public function view(User $user, SupplierBillLine $model): bool
    {
        return $this->allows($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->allows($user, 'create');
    }

    public function update(User $user, SupplierBillLine $model): bool
    {
        return $this->allows($user, 'update');
    }

    public function delete(User $user, SupplierBillLine $model): bool
    {
        return $this->allows($user, 'delete');
    }

    private function allows(User $user, string $action): bool
    {
        if (! ModuleGate::allows('procurement')) {
            return false;
        }

        return $user->is_super_admin || $user->hasPermission($action.' SupplierBillLine');
    }
}
