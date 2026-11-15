<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Voucher extends ErpModel
{
    public string $documentType = 'VCH';

    protected function casts(): array
    {
        return [
            'voucher_date' => 'date',
            'amount' => 'decimal:2',
        ];
    }

    protected $table = 'vouchers';

    public function party(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Party::class, 'party_id');
    }
    public function journal(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Accounts\Models\Journal::class, 'journal_id');
    }
}
