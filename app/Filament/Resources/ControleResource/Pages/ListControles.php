<?php

namespace App\Filament\Resources\ControleResource\Pages;

use App\Filament\Resources\ControleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListControles extends ListRecords
{
    protected static string $resource = ControleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
