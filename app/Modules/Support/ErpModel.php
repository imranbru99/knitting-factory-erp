<?php

declare(strict_types=1);

namespace App\Modules\Support;

use App\Modules\Support\Concerns\BelongsToCompany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RuntimeException;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ErpModel extends Model
{
    use BelongsToCompany;
    use LogsActivity;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected bool $scopesCompany = true;

    public bool $unlocking = false;

    public function scopesCompany(): bool
    {
        return $this->scopesCompany;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logExcept(['updated_at', 'created_at', 'deleted_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    protected static function booted(): void
    {
        static::updating(function (self $model): void {
            if ($model->unlocking || ! self::erpHasColumn($model, 'status')) {
                return;
            }

            $original = (string) $model->getOriginal('status');
            if (! in_array($original, ['approved', 'posted', 'closed', 'delivered'], true)) {
                return;
            }

            $dirty = array_diff(array_keys($model->getDirty()), ['updated_at', 'deleted_at']);
            if ($dirty !== []) {
                throw new RuntimeException('Document is locked after approval. Post a reversal instead of editing it.');
            }
        });
    }

    public function markStatus(string $status): void
    {
        $this->unlocking = true;
        $this->status = $status;
        if ($status === 'approved' && self::erpHasColumn($this, 'approved_by') && auth()->id()) {
            $this->approved_by = auth()->id();
        }
        $this->save();
        $this->unlocking = false;
    }
}
