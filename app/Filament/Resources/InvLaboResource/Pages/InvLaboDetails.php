<?php

namespace App\Filament\Resources\InvLaboResource\Pages;

use App\Filament\Resources\InvLaboResource;
use App\Models\InvLabo;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class InvLaboDetails extends Page
{
    use InteractsWithRecord;

    // public $record;
    protected static string $resource = InvLaboResource::class;

    protected static string $view = 'filament.resources.InvLabo-resource.pages.InvLabo-details';

    public function mount(int | string $record): void
    {
        $this->record = InvLabo::find($record);
    }
}
