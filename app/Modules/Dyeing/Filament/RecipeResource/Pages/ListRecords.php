<?php

declare(strict_types=1);

namespace App\Modules\Dyeing\Filament\RecipeResource\Pages;

use App\Filament\Pages\ErpListRecords;
use App\Modules\Dyeing\Filament\RecipeResource;

class ListRecords extends ErpListRecords
{
    protected static string $resource = RecipeResource::class;
}
