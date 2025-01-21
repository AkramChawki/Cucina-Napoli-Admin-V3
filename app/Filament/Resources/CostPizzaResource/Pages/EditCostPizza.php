<?php

namespace App\Filament\Resources\CostPizzaResource\Pages;

use App\Filament\Resources\CostPizzaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCostPizza extends EditRecord
{
    protected static string $resource = CostPizzaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
