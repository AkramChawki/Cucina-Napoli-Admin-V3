<?php

namespace App\Filament\Resources\InvLaboResource\Pages;

use App\Filament\Resources\InvLaboResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvLabos extends ListRecords
{
    protected static string $resource = InvLaboResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
