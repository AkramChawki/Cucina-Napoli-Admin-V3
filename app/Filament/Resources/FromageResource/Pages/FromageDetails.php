<?php

namespace App\Filament\Resources\FromageResource\Pages;

use App\Filament\Resources\FromageResource;
use App\Models\Fromage;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class FromageDetails extends Page
{
    use InteractsWithRecord;

    // public $record;
    protected static string $resource = FromageResource::class;

    protected static string $view = 'filament.resources.Fromage-resource.pages.Fromage-details';

    public function mount(int | string $record): void
    {
        $this->record = Fromage::find($record);
    }
}
