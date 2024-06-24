<?php

namespace App\Filament\Resources\RubriqueResource\Pages;

use App\Filament\Resources\RubriqueResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRubriques extends ListRecords
{
    protected static string $resource = RubriqueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
