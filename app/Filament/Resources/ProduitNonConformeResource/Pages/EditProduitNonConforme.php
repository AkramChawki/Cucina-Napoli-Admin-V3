<?php

namespace App\Filament\Resources\ProduitNonConformeResource\Pages;

use App\Filament\Resources\ProduitNonConformeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduitNonConforme extends EditRecord
{
    protected static string $resource = ProduitNonConformeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
