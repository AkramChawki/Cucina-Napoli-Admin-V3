<?php

namespace App\Filament\Resources\InventaireResource\Pages;

use App\Filament\Resources\InventaireResource;
use App\Models\Inventaire;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class InventaireDetails extends Page
{
    use InteractsWithRecord;

    // public $record;
    protected static string $resource = InventaireResource::class;

    protected static string $view = 'filament.resources.inventaire-resource.pages.inventaire-details';

    public function mount(int | string $record): void
    {
        $this->record = Inventaire::find($record);
    }
}
