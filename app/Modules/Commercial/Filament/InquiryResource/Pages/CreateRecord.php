<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament\InquiryResource\Pages;

use App\Modules\Commercial\Filament\InquiryResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = InquiryResource::class;
}
