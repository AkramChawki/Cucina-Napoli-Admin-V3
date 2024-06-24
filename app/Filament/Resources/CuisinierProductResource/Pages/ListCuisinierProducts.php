<?php

namespace App\Filament\Resources\CuisinierProductResource\Pages;

use App\Filament\Resources\CuisinierProductResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCuisinierProducts extends ListRecords
{
    protected static string $resource = CuisinierProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
