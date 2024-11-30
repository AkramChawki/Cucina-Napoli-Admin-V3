<?php

namespace App\Filament\Resources\FromageResource\Pages;

use App\Filament\Resources\FromageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFromage extends EditRecord
{
    protected static string $resource = FromageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
