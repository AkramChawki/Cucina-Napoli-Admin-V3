<?php

namespace App\Filament\Resources\LaboResource\Pages;

use App\Filament\Resources\LaboResource;
use App\Models\Labo;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class LaboDetails extends Page
{
    use InteractsWithRecord;

    // public $record;

    protected static string $resource = LaboResource::class;

    protected static string $view = 'filament.resources.order-resource.pages.cuisinier-order-details';

    public function mount(int | string $record): void
    {
        $this->record = Labo::find($record);
    }
}
