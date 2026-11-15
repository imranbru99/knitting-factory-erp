<?php

declare(strict_types=1);

namespace App\Modules\Masters\Models;

use App\Modules\Support\ErpModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class PartyContact extends ErpModel
{
    protected $table = 'party_contacts';

    public function party(): BelongsTo
    {
        return $this->belongsTo(\App\Modules\Masters\Models\Party::class, 'party_id');
    }
}
