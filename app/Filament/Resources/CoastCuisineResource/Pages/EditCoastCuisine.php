<?php

namespace App\Filament\Resources\CoastCuisineResource\Pages;

use App\Filament\Resources\CoastCuisineResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCoastCuisine extends EditRecord
{
    protected static string $resource = CoastCuisineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
