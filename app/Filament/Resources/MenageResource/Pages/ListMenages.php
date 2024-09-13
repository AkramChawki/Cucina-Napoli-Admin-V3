<?php

namespace App\Filament\Resources\MenageResource\Pages;

use App\Filament\Resources\MenageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMenages extends ListRecords
{
    protected static string $resource = MenageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
