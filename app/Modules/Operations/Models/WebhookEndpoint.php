<?php

declare(strict_types=1);

namespace App\Modules\Operations\Models;

use App\Modules\Support\ErpModel;
class WebhookEndpoint extends ErpModel
{
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected $table = 'webhook_endpoints';


}
