<?php

namespace App\Filament\Resources;

use App\Models\CostEconomat;
use App\Models\CuisinierProduct;
use App\Traits\CostResourceTrait;
use Filament\Resources\Resource;
use App\Filament\Resources\CostEconomatResource\Pages;


class CostEconomatResource extends Resource
{
    use CostResourceTrait;

    protected static ?string $model = CostEconomat::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Restaurant Management';
    protected static ?int $navigationSort = 4;
    protected static ?string $modelLabel = 'Cost Economat';

    protected static function getProductOptions()
    {
        $excludedProductIds = [204, 352, 281, 206, 280, 207, 353, 211, 210, 212, 213, 289, 290, 291, 357, 358, 374, 408, 434, 433, 453, 442, 201, 202, 335, 241, 242, 431, 438, 243, 25, 14, 16, 19, 20, 26, 24, 18, 17, 15, 401, 163, 167];

        return CuisinierProduct::whereHas('fiches', function ($query) {
            $query->where('fiche_id', 6);
        })
            ->whereNotIn('id', $excludedProductIds)
            ->pluck('designation', 'id');
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCostEconomats::route('/'),
            'create' => Pages\CreateCostEconomat::route('/create'),
            'edit' => Pages\EditCostEconomat::route('/{record}/edit'),
        ];
    }
}
