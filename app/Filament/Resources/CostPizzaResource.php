<?php

namespace App\Filament\Resources;

use App\Models\CostPizza;
use App\Models\CuisinierProduct;
use App\Traits\CostResourceTrait;
use Filament\Resources\Resource;
use App\Filament\Resources\CostPizzaResource\Pages;

class CostPizzaResource extends Resource
{
    use CostResourceTrait;

    protected static ?string $model = CostPizza::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-euro';
    protected static ?string $navigationGroup = 'Restaurant Management';
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'Cost Pizza';

    protected static function getProductOptions()
    {
        return CuisinierProduct::whereHas('fiches', function ($query) {
            $query->where('fiche_id', 5);
        })->pluck('designation', 'id');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCostPizzas::route('/'),
            'create' => Pages\CreateCostPizza::route('/create'),
            'edit' => Pages\EditCostPizza::route('/{record}/edit'),
        ];
    }
}
