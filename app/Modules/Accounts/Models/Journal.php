<?php

declare(strict_types=1);

namespace App\Modules\Accounts\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Journal extends ErpModel
{
    public string $documentType = 'JV';

    protected function casts(): array
    {
        return [
            'journal_date' => 'date',
        ];
    }

    protected $table = 'journals';

    public function lines(): HasMany
    {
        return $this->hasMany(\App\Modules\Accounts\Models\JournalLine::class);
    }
}
