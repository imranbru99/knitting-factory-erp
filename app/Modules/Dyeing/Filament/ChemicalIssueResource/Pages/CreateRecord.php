<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament\ChemicalIssueResource\Pages;

use App\Modules\Dyeing\Filament\ChemicalIssueResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = ChemicalIssueResource::class;
}
