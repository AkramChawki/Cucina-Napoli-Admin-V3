<?php

namespace App\Filament\Resources\CoastCuisineResource\Pages;

use App\Filament\Resources\CoastCuisineResource;
use App\Models\CoastCuisine;
use Filament\Resources\Pages\Page;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ViewConsumption extends Page
{
    protected static string $resource = CoastCuisineResource::class;

    protected static string $view = 'filament.resources.coast-cuisines.view-consumption';

    public $record;
    public $daysInMonth;
    public $products;
    public $consumptionData;

    public function mount(string|CoastCuisine $record): void
    {
        // If record is a string (ID), load the model
        if (is_string($record)) {
            $record = CoastCuisine::find($record);
        }

        $this->record = $record;
        $date = Carbon::createFromDate($record->year, $record->month, 1);
        $this->daysInMonth = $date->daysInMonth;

        // Get products from fiche_id = 1
        $this->products = \App\Models\CuisinierProduct::whereHas('fiches', function ($query) {
            $query->where('fiche_id', 1);
        })->get();

        // Get consumption data and manually group by product_id
        $consumptionRecords = CoastCuisine::where('restaurant_id', $record->restaurant_id)
            ->where('month', $record->month)
            ->where('year', $record->year)
            ->get();

        // Group the data manually using a Collection
        $this->consumptionData = $consumptionRecords->groupBy('product_id')
            ->map(function (Collection $group) {
                return $group->keyBy('day');
            })
            ->toArray();
    }
}