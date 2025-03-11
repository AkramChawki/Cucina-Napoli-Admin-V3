<?php

namespace App\Filament\Exports;

use App\Models\ClotureCaisse;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Filament\Actions\Exports\ExportColumn;
use Illuminate\Database\Eloquent\Builder;

class ClotureCaisseExporter extends Exporter
{
    protected static ?string $model = ClotureCaisse::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')
                ->label('Nom'),
                
            ExportColumn::make('restau')
                ->label('Restaurant'),
                
            ExportColumn::make('date')
                ->label('Date')
                ->formatStateUsing(fn (ClotureCaisse $record): string => $record->date->format('d/m/Y')),
                
            ExportColumn::make('time')
                ->label('Heure'),
                
            ExportColumn::make('responsable')
                ->label('Responsable'),
                
            ExportColumn::make('montant')
                ->label('Montant Total')
                ->formatStateUsing(fn ($state) => number_format($state, 2) . ' MAD'),
                
            ExportColumn::make('montantE')
                ->label('Montant Espèce')
                ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) . ' MAD' : ''),
                
            ExportColumn::make('cartebancaire')
                ->label('Carte Bancaire')
                ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) . ' MAD' : ''),
                
            ExportColumn::make('cartebancaireLivraison')
                ->label('CB Livraison')
                ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) . ' MAD' : ''),
                
            ExportColumn::make('virement')
                ->label('Virement')
                ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) . ' MAD' : ''),
                
            ExportColumn::make('cheque')
                ->label('Chèque')
                ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) . ' MAD' : ''),
                
            ExportColumn::make('compensation')
                ->label('Compensation')
                ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) . ' MAD' : ''),
                
            ExportColumn::make('familleAcc')
                ->label('Famille & Accompagnant')
                ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) . ' MAD' : ''),
                
            ExportColumn::make('erreurPizza')
                ->label('Erreur Pizza')
                ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) . ' MAD' : ''),
                
            ExportColumn::make('erreurCuisine')
                ->label('Erreur Cuisine')
                ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) . ' MAD' : ''),
                
            ExportColumn::make('erreurServeur')
                ->label('Erreur Serveur')
                ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) . ' MAD' : ''),
                
            ExportColumn::make('erreurCaisse')
                ->label('Erreur Caisse')
                ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) . ' MAD' : ''),
                
            ExportColumn::make('perteEmporte')
                ->label('Perte Emporte')
                ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) . ' MAD' : ''),
                
            ExportColumn::make('giveawayPizza')
                ->label('Giveaway Pizza')
                ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) . ' MAD' : ''),
                
            ExportColumn::make('giveawayPasta')
                ->label('Giveaway Pasta')
                ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) . ' MAD' : ''),
                
            ExportColumn::make('glovoE')
                ->label('Glovo Espèce')
                ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) . ' MAD' : ''),
                
            ExportColumn::make('glovoC')
                ->label('Glovo Carte')
                ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) . ' MAD' : ''),
                
            ExportColumn::make('appE')
                ->label('App Espèce')
                ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) . ' MAD' : ''),
                
            ExportColumn::make('appC')
                ->label('App Carte')
                ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) . ' MAD' : ''),
                
            ExportColumn::make('shooting')
                ->label('Shooting')
                ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) . ' MAD' : ''),
                
            ExportColumn::make('ComGlovo')
                ->label('Commission Glovo')
                ->formatStateUsing(fn ($state) => $state ? number_format($state, 2) . ' MAD' : ''),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Votre export de ' . number_format($export->successful_rows) . ' clotures de caisse';

        if ($export->failed_rows) {
            $body .= ' (' . number_format($export->failed_rows) . ' echec)';
        }

        $body .= ' est prêt à télécharger.';

        return $body;
    }
    
    public function getFileName(Export $export): string
    {
        return 'cloture-caisse-export-' . $export->created_at->format('Y-m-d');
    }
}