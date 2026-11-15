<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament\RecipeResource\Pages;

use App\Modules\Dyeing\Filament\RecipeResource;
use Filament\Resources\Pages\CreateRecord as CreateRecordPage;

class CreateRecord extends CreateRecordPage
{
    protected static string $resource = RecipeResource::class;
}
