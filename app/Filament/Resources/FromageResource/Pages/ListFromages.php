<?php

namespace App\Filament\Resources\FromageResource\Pages;

use App\Filament\Resources\FromageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFromages extends ListRecords
{
    protected static string $resource = FromageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
