<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament\ChemicalIssueResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Dyeing\Filament\ChemicalIssueResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = ChemicalIssueResource::class;
}
