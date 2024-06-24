<?php

namespace App\Filament\Resources\CuisinierCategoryResource\Pages;

use App\Filament\Resources\CuisinierCategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCuisinierCategories extends ListRecords
{
    protected static string $resource = CuisinierCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
