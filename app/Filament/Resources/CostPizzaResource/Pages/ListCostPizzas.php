<?php

namespace App\Filament\Resources\CostPizzaResource\Pages;

use App\Filament\Resources\CostPizzaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCostPizzas extends ListRecords
{
    protected static string $resource = CostPizzaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
