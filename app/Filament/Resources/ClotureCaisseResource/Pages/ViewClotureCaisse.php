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
                                    ->date('d/m/Y'),
                                TextEntry::make('time'),
                                TextEntry::make('responsable'),
                            ]),
                    ])->collapsible(),

                Section::make('Montants Principaux')
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
                                TextEntry::make('cartebancaireLivraison')
                                    ->label('CB Livraison')
                                    ->money('mad'),
                            ]),
                    ])->collapsible(),

                Section::make('Glovo & Applications')
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
                                TextEntry::make('appE')
                                    ->label('App Espèce')
                                    ->money('mad'),
                                TextEntry::make('appC')
                                    ->label('App Carte')
                                    ->money('mad'),
                            ]),
                    ])->collapsible(),

                Section::make('Autres Paiements')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('virement')
                                    ->label('Virement')
                                    ->money('mad'),
                                TextEntry::make('cheque')
                                    ->label('Chèque')
                                    ->money('mad'),
                                TextEntry::make('compensation')
                                    ->money('mad'),
                            ]),
                    ])->collapsible(),

                Section::make('Erreurs et Ajustements')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('familleAcc')
                                    ->label('Famille & Accompagnant')
                                    ->money('mad'),
                                TextEntry::make('erreurPizza')
                                    ->label('Erreur Pizza')
                                    ->money('mad'),
                                TextEntry::make('erreurCuisine')
                                    ->label('Erreur Cuisine')
                                    ->money('mad'),
                                TextEntry::make('erreurServeur')
                                    ->label('Erreur Serveur')
                                    ->money('mad'),
                                TextEntry::make('erreurCaisse')
                                    ->label('Erreur Caisse')
                                    ->money('mad'),
                                TextEntry::make('perteEmporte')
                                    ->label('Perte Emporte')
                                    ->money('mad'),
                                TextEntry::make('giveawayPizza')
                                    ->money('mad'),
                                TextEntry::make('giveawayPasta')
                                    ->money('mad'),
                                TextEntry::make('shooting')
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