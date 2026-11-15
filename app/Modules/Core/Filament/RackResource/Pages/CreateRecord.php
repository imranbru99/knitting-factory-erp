<?php

declare(strict_types=1);

namespace App\Modules\Core\Filament\RackResource\Pages;

use App\Modules\Core\Filament\RackResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = RackResource::class;
}
