<?php

namespace App\Filament\Resources\CoastCuisineResource\Pages;

use App\Filament\Resources\CoastCuisineResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCoastCuisines extends ListRecords
{
    protected static string $resource = CoastCuisineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
