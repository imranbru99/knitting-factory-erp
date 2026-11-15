<?php

declare(strict_types=1);

namespace App\Modules\Support\Concerns;

use App\Models\User;
use App\Modules\Support\CompanyContext;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

trait BelongsToCompany
{
    /** @var array<string, array<int, string>> */
    protected static array $erpColumnCache = [];

    public static function bootBelongsToCompany(): void
    {
        static::addGlobalScope('company', function (Builder $builder): void {
            /** @var Model $model */
            $model = $builder->getModel();
            if (! method_exists($model, 'scopesCompany') || ! $model->scopesCompany()) {
                return;
            }

            $companyId = CompanyContext::id();
            if ($companyId === null || ! self::erpHasColumn($model, 'company_id')) {
                return;
            }

            $builder->where($model->qualifyColumn('company_id'), $companyId);
        });

        static::creating(function (Model $model): void {
            if (method_exists($model, 'scopesCompany') && $model->scopesCompany() && self::erpHasColumn($model, 'company_id') && empty($model->getAttribute('company_id'))) {
                $model->setAttribute('company_id', CompanyContext::id());
            }

            $user = auth()->user();
            if ($user instanceof User && self::erpHasColumn($model, 'created_by') && empty($model->getAttribute('created_by'))) {
                $model->setAttribute('created_by', $user->id);
            }

            if (self::erpHasColumn($model, 'unit_id') && empty($model->getAttribute('unit_id'))) {
                $model->setAttribute('unit_id', CompanyContext::unitId());
            }
        });
    }

    protected static function erpHasColumn(Model $model, string $column): bool
    {
        $table = $model->getTable();
        self::$erpColumnCache[$table] ??= Schema::getColumnListing($table);

        return in_array($column, self::$erpColumnCache[$table], true);
    }
}
