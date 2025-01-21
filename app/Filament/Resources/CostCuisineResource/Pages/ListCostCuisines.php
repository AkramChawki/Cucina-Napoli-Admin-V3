<?php

namespace App\Filament\Resources\CostCuisineResource\Pages;

use App\Filament\Resources\CostCuisineResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCostCuisines extends ListRecords
{
    protected static string $resource = CostCuisineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
