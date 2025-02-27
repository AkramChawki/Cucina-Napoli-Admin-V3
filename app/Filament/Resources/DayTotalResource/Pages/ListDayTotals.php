<?php

namespace App\Filament\Resources\DayTotalResource\Pages;

use App\Filament\Resources\DayTotalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDayTotals extends ListRecords
{
    protected static string $resource = DayTotalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
