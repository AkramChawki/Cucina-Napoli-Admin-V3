<?php

namespace App\Filament\Resources\DayTotalResource\Pages;

use App\Filament\Resources\DayTotalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDayTotal extends EditRecord
{
    protected static string $resource = DayTotalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
