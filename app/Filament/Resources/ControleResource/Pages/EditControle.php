<?php

namespace App\Filament\Resources\ControleResource\Pages;

use App\Filament\Resources\ControleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditControle extends EditRecord
{
    protected static string $resource = ControleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
