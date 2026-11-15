<?php

declare(strict_types=1);

namespace App\Modules\Procurement\Filament\RfqQuoteResource\Pages;

use App\Modules\Procurement\Filament\RfqQuoteResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = RfqQuoteResource::class;
}
