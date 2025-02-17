<?php

namespace App\Filament\Resources;

use App\Models\CostConsomable;
use App\Models\CuisinierProduct;
use App\Traits\CostResourceTrait;
use Filament\Resources\Resource;



class CostConsomableResource extends Resource
{
    use CostResourceTrait;

    protected static ?string $model = CostConsomable::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Restaurant Management';
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'Cost Consommable';

    protected static function getProductOptions()
    {
        $includedProductIds = [204,352,281,206,280,207,353,211,210,212,213,289,290,291,357,358,374,408,434,433,453,442,201,202,335,241,242,431,438,243,25,14,16,19,20,26,24,18,17,15,401,163,167];
        
        return CuisinierProduct::whereIn('id', $includedProductIds)->pluck('designation', 'id');
    }
}