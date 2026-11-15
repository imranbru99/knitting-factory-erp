<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament\OrderAmendmentResource\Pages;

use App\Modules\Commercial\Filament\OrderAmendmentResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = OrderAmendmentResource::class;
}
