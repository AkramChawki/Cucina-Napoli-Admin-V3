<?php

namespace App\Filament\Resources\InvLaboResource\Pages;

use App\Filament\Resources\InvLaboResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInvLabo extends EditRecord
{
    protected static string $resource = InvLaboResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
