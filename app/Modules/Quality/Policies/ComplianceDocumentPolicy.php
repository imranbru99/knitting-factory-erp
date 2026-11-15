<?php

declare(strict_types=1);

namespace App\Modules\Quality\Policies;

use App\Models\User;
use App\Modules\Quality\Models\ComplianceDocument;
use App\Modules\Support\ModuleGate;

class ComplianceDocumentPolicy
{
    public function viewAny(User $user): bool
    {
        return $this->allows($user, 'view');
    }

    public function view(User $user, ComplianceDocument $model): bool
    {
        return $this->allows($user, 'view');
    }

    public function create(User $user): bool
    {
        return $this->allows($user, 'create');
    }

    public function update(User $user, ComplianceDocument $model): bool
    {
        return $this->allows($user, 'update');
    }

    public function delete(User $user, ComplianceDocument $model): bool
    {
        return $this->allows($user, 'delete');
    }

    private function allows(User $user, string $action): bool
    {
        if (! ModuleGate::allows('quality')) {
            return false;
        }

        return $user->is_super_admin || $user->hasPermission($action.' ComplianceDocument');
    }
}
