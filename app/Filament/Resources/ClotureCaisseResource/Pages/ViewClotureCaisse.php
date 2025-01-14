<?php

namespace App\Filament\Resources\ClotureCaisseResource\Pages;

use App\Filament\Resources\ClotureCaisseResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Grid;

class ViewClotureCaisse extends ViewRecord
{
    protected static string $resource = ClotureCaisseResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            ClotureCaisseResource\Widgets\ClotureCaisseStatsOverview::class
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Information Générale')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Nom'),
                                TextEntry::make('restau')
                                    ->label('Restaurant'),
                                TextEntry::make('date')
                                    ->date(),
                                TextEntry::make('time')
                                    ->time(),
                                TextEntry::make('caissierE')
                                    ->label('Caissier Entrant'),
                                TextEntry::make('caissierS')
                                    ->label('Caissier Sortant'),
                            ]),
                    ])->collapsible(),

                Section::make('Montants')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('montant')
                                    ->label('Montant Caisse')
                                    ->money('mad')
                                    ->color('success'),
                                TextEntry::make('montantE')
                                    ->label('Montant Espèce')
                                    ->money('mad'),
                                TextEntry::make('cartebancaire')
                                    ->label('Carte Bancaire')
                                    ->money('mad'),
                            ]),
                    ])->collapsible(),

                Section::make('Glovo')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('glovoE')
                                    ->label('Glovo Espèce')
                                    ->money('mad'),
                                TextEntry::make('glovoC')
                                    ->label('Glovo Carte')
                                    ->money('mad'),
                                TextEntry::make('ComGlovo')
                                    ->label('Commission Glovo')
                                    ->money('mad')
                                    ->color('danger'),
                            ]),
                    ])->collapsible(),

                Section::make('Livraison.ma')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('LivE')
                                    ->label('Livraison.ma Espèce')
                                    ->money('mad'),
                                TextEntry::make('LivC')
                                    ->label('Livraison.ma Carte')
                                    ->money('mad'),
                                TextEntry::make('ComLivraison')
                                    ->label('Commission Livraison')
                                    ->money('mad')
                                    ->color('danger'),
                            ]),
                    ])->collapsible(),

                Section::make('Autres Paiements')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('virement')
                                    ->label('Virement Instantané')
                                    ->money('mad'),
                                TextEntry::make('cheque')
                                    ->label('Chèque')
                                    ->money('mad'),
                                TextEntry::make('Compensation')
                                    ->money('mad'),
                            ]),
                    ])->collapsible(),

                Section::make('Signature')
                    ->schema([
                        ImageEntry::make('signature')
                            ->height(200)
                            ->width(300),
                    ])->collapsible(),
            ]);
    }
}