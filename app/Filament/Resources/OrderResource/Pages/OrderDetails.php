<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\custom;
use Filament\Resources\Pages\Page;

class OrderDetails extends Page
{
    use InteractsWithRecord;

    // public $record;

    protected static string $resource = OrderResource::class;

    protected static string $view = 'filament.resources.order-resource.pages.order-details';

    public function mount(int | string $record): void
    {
        $this->record = Order::find($record);
    }
}
