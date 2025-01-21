<?php

namespace App\Filament\Resources\BMLResource\Pages;

use App\Filament\Resources\BMLResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBMLS extends ListRecords
{
    protected static string $resource = BMLResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
