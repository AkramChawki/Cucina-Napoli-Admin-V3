<?php

namespace App\Filament\Resources\LaboResource\Pages;

use App\Filament\Resources\LaboResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLabos extends ListRecords
{
    protected static string $resource = LaboResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
