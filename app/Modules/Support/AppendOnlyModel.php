<?php

declare(strict_types=1);

namespace App\Modules\Support;

use App\Modules\Support\Concerns\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AppendOnlyModel extends Model
{
    use BelongsToCompany;
    use LogsActivity;

    protected $guarded = ['id'];

    protected bool $scopesCompany = true;

    public function scopesCompany(): bool
    {
        return $this->scopesCompany;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['updated_at', 'created_at'])
            ->dontSubmitEmptyLogs();
    }

    protected static function booted(): void
    {
        static::updating(function (): void {
            throw new RuntimeException('Ledger rows are append-only.');
        });

        static::deleting(function (): void {
            throw new RuntimeException('Ledger rows are append-only.');
        });
    }
}
