<?php

namespace App\Filament\Resources\CoastConsomableResource\Pages;

use App\Filament\Resources\CoastConsomableResource;
use Filament\Resources\Pages\Page;
use Carbon\Carbon;

class ViewConsumption extends Page
{
    protected static string $resource = CoastConsomableResource::class;

    // Updated view path to match the directory structure
    protected static string $view = 'filament.resources.coast-consomables.view-consumption';

    public $record;
    public $daysInMonth;
    public $products;
    public $consumptionData;

    public function mount($record): void
    {
        $this->record = $record;
        $date = Carbon::createFromDate($record->year, $record->month, 1);
        $this->daysInMonth = $date->daysInMonth;

        // Get all products for this restaurant in this month
        $this->products = \App\Models\CuisinierProduct::whereIn('id', [
            204,352,281,206,280,207,353,211,210,212,213,289,290,291,
            357,358,374,408,434,433,453,442,201,202,335,241,242,431,
            438,243,25,14,16,19,20,26,24,18,17,15,401,163,167
        ])->get();

        // Get consumption data
        $this->consumptionData = \App\Models\CoastConsomable::where('restaurant_id', $record->restaurant_id)
            ->where('month', $record->month)
            ->where('year', $record->year)
            ->get()
            ->groupBy('product_id');
    }
}