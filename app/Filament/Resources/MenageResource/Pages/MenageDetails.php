<?php

namespace App\Filament\Resources\MenageResource\Pages;

use App\Filament\Resources\MenageResource;
use App\Models\Menage;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class MenageDetails extends Page
{
    use InteractsWithRecord;

    // public $record;

    protected static string $resource = MenageResource::class;

    protected static string $view = 'filament.resources.order-resource.pages.cuisinier-order-details';

    public function mount(int | string $record): void
    {
        $this->record = Menage::find($record);
    }
}
