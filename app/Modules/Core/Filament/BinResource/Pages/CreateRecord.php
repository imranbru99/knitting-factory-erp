<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\BinResource\Pages;

use App\Modules\Core\Filament\BinResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = BinResource::class;
}
