<?php

namespace App\Filament\Resources\CoastConsomableResource\Pages;

use App\Filament\Resources\CoastConsomableResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCoastConsomable extends EditRecord
{
    protected static string $resource = CoastConsomableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
