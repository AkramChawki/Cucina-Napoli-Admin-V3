<?php

namespace App\Filament\Resources\DKResource\Pages;

use App\Filament\Resources\DKResource;
use App\Models\DK;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class DKDetails extends Page
{
    use InteractsWithRecord;

    // public $record;

    protected static string $resource = DKResource::class;

    protected static string $view = 'filament.resources.order-resource.pages.cuisinier-order-details';

    public function mount(int | string $record): void
    {
        $this->record = DK::find($record);
    }
}
