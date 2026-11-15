<?php

declare(strict_types=1);

namespace App\Modules\Delivery\Policies;

use App\Models\User;
use App\Modules\Delivery\Models\SalesInvoice;
use App\Modules\Support\ModuleGate;

class SalesInvoicePolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allows($user, 'view');
    }

    public function view(User $user, SalesInvoice $model): bool
    {
        return $this->allows($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->allows($user, 'create');
    }

    public function update(User $user, SalesInvoice $model): bool
    {
        return $this->allows($user, 'update');
    }

    public function delete(User $user, SalesInvoice $model): bool
    {
        return $this->allows($user, 'delete');
    }

    private function allows(User $user, string $action): bool
    {
        if (! ModuleGate::allows('delivery')) {
            return false;
        }

        return $user->is_super_admin || $user->hasPermission($action.' SalesInvoice');
    }
}
