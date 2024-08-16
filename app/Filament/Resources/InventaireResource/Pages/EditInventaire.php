<?php

namespace App\Filament\Resources\InventaireResource\Pages;

use App\Filament\Resources\InventaireResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInventaire extends EditRecord
{
    protected static string $resource = InventaireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
