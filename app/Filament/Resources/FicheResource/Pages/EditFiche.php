<?php

namespace App\Filament\Resources\FicheResource\Pages;

use App\Filament\Resources\FicheResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFiche extends EditRecord
{
    protected static string $resource = FicheResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
