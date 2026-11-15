<?php

declare(strict_types=1);

namespace App\Modules\Core\Models;

use App\Modules\Support\ErpModel;
class Attachment extends ErpModel
{
    protected function casts(): array
    {
        return [
            'expires_on' => 'date',
        ];
    }

    protected $table = 'attachments';


}
