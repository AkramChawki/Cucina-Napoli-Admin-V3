<?php

namespace App\Filament\Resources\CostCuisineResource\Pages;

use App\Filament\Resources\CostCuisineResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCostCuisine extends EditRecord
{
    protected static string $resource = CostCuisineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
