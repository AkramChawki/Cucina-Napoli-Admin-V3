<?php

namespace App\Filament\Resources\ClotureCaisseResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class ClotureCaisseStatsOverview extends BaseWidget
{
    public $record;

    protected function getCards(): array
    {
        return [
            Card::make('Total Caisse', number_format($this->record->montant, 2) . ' MAD')
                ->description('Montant total en caisse')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('success'),

            Card::make('Total Espèces', number_format($this->record->montantE, 2) . ' MAD')
                ->description('Montant total en espèces')
                ->descriptionIcon('heroicon-s-currency-dollar')
                ->color('success'),

            Card::make('Total Commissions', number_format($this->record->ComGlovo + $this->record->ComLivraison, 2) . ' MAD')
                ->description('Total des commissions (Glovo + Livraison.ma)')
                ->descriptionIcon('heroicon-s-calculator')
                ->color('danger'),

            Card::make('Total Carte Bancaire', number_format($this->record->cartebancaire, 2) . ' MAD')
                ->description('Paiements par carte bancaire')
                ->descriptionIcon('heroicon-s-credit-card')
                ->color('primary'),

            Card::make('Total Glovo', number_format($this->record->glovoE + $this->record->glovoC, 2) . ' MAD')
                ->description('Total des paiements Glovo')
                ->descriptionIcon('heroicon-s-truck')
                ->color('warning'),

            Card::make('Total Livraison.ma', number_format($this->record->LivE + $this->record->LivC, 2) . ' MAD')
                ->description('Total des paiements Livraison.ma')
                ->descriptionIcon('heroicon-s-truck')
                ->color('warning'),
        ];
    }
}