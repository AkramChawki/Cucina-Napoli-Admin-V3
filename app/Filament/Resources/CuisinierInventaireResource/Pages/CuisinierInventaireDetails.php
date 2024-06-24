<?php

namespace App\Filament\Resources\CuisinierInventaireResource\Pages;

use App\Filament\Resources\CuisinierInventaireResource;
use App\Models\CuisinierInventaire;
use App\Models\CuisinierOrder;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class CuisinierInventaireDetails extends Page
{
    use InteractsWithRecord;

    // public $record;
    protected static string $resource = CuisinierInventaireResource::class;

    protected static string $view = 'filament.resources.inventaire-resource.pages.cuisinier-inventaire-details';

    public function mount(int | string $record): void
    {
        $this->record = CuisinierInventaire::find($record);
    }
}
