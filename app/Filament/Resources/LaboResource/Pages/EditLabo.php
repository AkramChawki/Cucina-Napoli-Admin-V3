<?php

namespace App\Filament\Resources\LaboResource\Pages;

use App\Filament\Resources\LaboResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLabo extends EditRecord
{
    protected static string $resource = LaboResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
