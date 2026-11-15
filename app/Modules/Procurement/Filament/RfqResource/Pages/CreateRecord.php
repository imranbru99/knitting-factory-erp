<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament\RfqResource\Pages;

use App\Modules\Procurement\Filament\RfqResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = RfqResource::class;
}
