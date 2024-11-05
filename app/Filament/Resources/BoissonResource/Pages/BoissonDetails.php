<?php

namespace App\Filament\Resources\BoissonResource\Pages;

use App\Filament\Resources\BoissonResource;
use App\Models\Boisson;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class BoissonDetails extends Page
{
    use InteractsWithRecord;

    // public $record;

    protected static string $resource = BoissonResource::class;

    protected static string $view = 'filament.resources.order-resource.pages.cuisinier-order-details';

    public function mount(int | string $record): void
    {
        $this->record = Boisson::find($record);
    }
}
