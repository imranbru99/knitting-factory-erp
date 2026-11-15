<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Models;

use App\Modules\Support\AppendOnlyModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class JournalLine extends AppendOnlyModel
{
    protected function casts(): array
    {
        return [
            'debit' => 'decimal:2',
            'credit' => 'decimal:2',
        ];
    }

    protected $table = 'journal_lines';

    public function journal(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Accounts\Models\Journal::class, 'journal_id');
    }
    public function account(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Accounts\Models\Account::class, 'account_id');
    }
    public function cost_center(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Accounts\Models\CostCenter::class, 'cost_center_id');
    }
    public function party(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Party::class, 'party_id');
    }
}
