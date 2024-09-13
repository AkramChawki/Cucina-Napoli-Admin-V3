<?php

namespace App\Filament\Resources\MenageResource\Pages;

use App\Filament\Resources\MenageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMenage extends EditRecord
{
    protected static string $resource = MenageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
