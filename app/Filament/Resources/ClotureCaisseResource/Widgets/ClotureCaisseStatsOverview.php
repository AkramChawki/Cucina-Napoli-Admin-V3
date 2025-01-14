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

            Card::make('Total Carte Bancaire', number_format($this->record->cartebancaire + $this->record->cartebancaireLivraison, 2) . ' MAD')
                ->description('Paiements par carte bancaire (avec livraison)')
                ->descriptionIcon('heroicon-s-credit-card')
                ->color('primary'),

            Card::make('Total Glovo', number_format($this->record->glovoE + $this->record->glovoC, 2) . ' MAD')
                ->description('Total des paiements Glovo')
                ->descriptionIcon('heroicon-s-truck')
                ->color('warning'),

            Card::make('Total App', number_format($this->record->appE + $this->record->appC, 2) . ' MAD')
                ->description('Total des paiements App')
                ->descriptionIcon('heroicon-s-device-phone-mobile')
                ->color('warning'),

            Card::make('Total Erreurs', number_format(
                    $this->record->erreurPizza +
                    $this->record->erreurCuisine +
                    $this->record->erreurServeur +
                    $this->record->erreurCaisse, 2
                ) . ' MAD')
                ->description('Total des erreurs')
                ->descriptionIcon('heroicon-s-exclamation-triangle')
                ->color('danger'),
        ];
    }
}