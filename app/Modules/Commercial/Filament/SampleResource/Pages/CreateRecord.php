<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament\SampleResource\Pages;

use App\Modules\Commercial\Filament\SampleResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = SampleResource::class;
}
