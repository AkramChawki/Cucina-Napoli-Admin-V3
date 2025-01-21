<?php

namespace App\Filament\Resources\CostConsomableResource\Pages;

use App\Filament\Resources\CostConsomableResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCostConsomable extends EditRecord
{
    protected static string $resource = CostConsomableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
