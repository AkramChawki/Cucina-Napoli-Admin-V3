<?php

namespace App\Filament\Resources\CuisinierOrderResource\Pages;

use App\Filament\Resources\CuisinierOrderResource;
use App\Models\CuisinierOrder;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class CuisinierOrderDetails extends Page
{
    use InteractsWithRecord;

    // public $record;

    protected static string $resource = CuisinierOrderResource::class;

    protected static string $view = 'filament.resources.order-resource.pages.cuisinier-order-details';

    public function mount(int | string $record): void
    {
        $this->record = CuisinierOrder::find($record);
    }
}
