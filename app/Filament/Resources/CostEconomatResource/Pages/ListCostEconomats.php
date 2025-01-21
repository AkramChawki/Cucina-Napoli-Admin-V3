<?php

namespace App\Filament\Resources\CostEconomatResource\Pages;

use App\Filament\Resources\CostEconomatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCostEconomats extends ListRecords
{
    protected static string $resource = CostEconomatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
