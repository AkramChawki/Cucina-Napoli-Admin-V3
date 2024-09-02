<?php

namespace App\Filament\Resources\DKResource\Pages;

use App\Filament\Resources\DKResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDK extends EditRecord
{
    protected static string $resource = DKResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
