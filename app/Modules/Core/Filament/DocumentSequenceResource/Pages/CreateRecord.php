<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\DocumentSequenceResource\Pages;

use App\Modules\Core\Filament\DocumentSequenceResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = DocumentSequenceResource::class;
}
