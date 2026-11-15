<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament\BomResource\Pages;

use App\Modules\Commercial\Filament\BomResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = BomResource::class;
}
