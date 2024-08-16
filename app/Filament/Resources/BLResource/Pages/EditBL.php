<?php

namespace App\Filament\Resources\BLResource\Pages;

use App\Filament\Resources\BLResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBL extends EditRecord
{
    protected static string $resource = BLResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
