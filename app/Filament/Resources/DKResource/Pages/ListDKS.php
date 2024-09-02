<?php

namespace App\Filament\Resources\DKResource\Pages;

use App\Filament\Resources\DKResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDKS extends ListRecords
{
    protected static string $resource = DKResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
