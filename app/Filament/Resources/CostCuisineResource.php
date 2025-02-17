<?php

namespace App\Filament\Resources;

use App\Models\CostCuisine;
use App\Models\CuisinierProduct;
use App\Traits\CostResourceTrait;
use Filament\Resources\Resource;

class CostCuisineResource extends Resource
{
    use CostResourceTrait;

    protected static ?string $model = CostCuisine::class;
    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationGroup = 'Restaurant Management';
    protected static ?int $navigationSort = 4;
    protected static ?string $modelLabel = 'Cost Cuisine';

    protected static function getProductOptions()
    {
        return CuisinierProduct::whereHas('fiches', function ($query) {
            $query->where('fiche_id', 1);
        })->pluck('designation', 'id');
    }
}