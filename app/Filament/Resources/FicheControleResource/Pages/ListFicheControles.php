<?php

namespace App\Filament\Resources\FicheControleResource\Pages;

use App\Filament\Resources\FicheControleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFicheControles extends ListRecords
{
    protected static string $resource = FicheControleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
