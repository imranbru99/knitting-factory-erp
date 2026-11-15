<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament\SalesOrderResource\Pages;

use App\Modules\Commercial\Filament\SalesOrderResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = SalesOrderResource::class;
}
