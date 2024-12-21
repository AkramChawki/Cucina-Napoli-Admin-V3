<?php

namespace App\Filament\Resources\FicheControleResource\Pages;

use App\Filament\Resources\FicheControleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFicheControle extends EditRecord
{
    protected static string $resource = FicheControleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
