<?php

namespace App\Filament\Resources\RubriqueResource\Pages;

use App\Filament\Resources\RubriqueResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRubrique extends EditRecord
{
    protected static string $resource = RubriqueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
