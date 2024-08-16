<?php

namespace App\Filament\Resources\BLResource\Pages;

use App\Filament\Resources\BLResource;
use App\Models\BL;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class BLDetails extends Page
{
    use InteractsWithRecord;

    // public $record;
    protected static string $resource = BLResource::class;

    protected static string $view = 'filament.resources.bl-resource.pages.bl-details';

    public function mount(int | string $record): void
    {
        $this->record = BL::find($record);
    }
}
