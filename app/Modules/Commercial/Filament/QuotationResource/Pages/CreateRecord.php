<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament\QuotationResource\Pages;

use App\Modules\Commercial\Filament\QuotationResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = QuotationResource::class;
}
