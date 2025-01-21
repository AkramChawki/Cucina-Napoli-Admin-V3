<?php

namespace App\Filament\Resources\BMLResource\Pages;

use App\Filament\Resources\BMLResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBML extends EditRecord
{
    protected static string $resource = BMLResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
