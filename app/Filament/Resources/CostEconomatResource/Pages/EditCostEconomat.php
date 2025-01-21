<?php

namespace App\Filament\Resources\CostEconomatResource\Pages;

use App\Filament\Resources\CostEconomatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCostEconomat extends EditRecord
{
    protected static string $resource = CostEconomatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
