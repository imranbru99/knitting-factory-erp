<?php

declare(strict_types=1);

namespace App\Modules\Commercial\Filament\InquiryResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Commercial\Filament\InquiryResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = InquiryResource::class;
}
