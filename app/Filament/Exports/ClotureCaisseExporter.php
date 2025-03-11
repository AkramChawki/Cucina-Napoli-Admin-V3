<?php

namespace App\Filament\Exports;

use App\Models\ClotureCaisse;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Database\Eloquent\Builder;

class ClotureCaisseExporter extends Exporter
{
    protected static ?string $model = ClotureCaisse::class;

    public static function getColumns(): array
    {
        return [
            'name' => 'Nom',
            'restau' => 'Restaurant',
            'date' => 'Date',
            'time' => 'Heure',
            'responsable' => 'Responsable',
            'montant' => 'Montant Total',
            'montantE' => 'Montant Espèce',
            'cartebancaire' => 'Carte Bancaire',
            'cartebancaireLivraison' => 'CB Livraison',
            'virement' => 'Virement',
            'cheque' => 'Chèque',
            'compensation' => 'Compensation',
            'familleAcc' => 'Famille & Accompagnant',
            'erreurPizza' => 'Erreur Pizza',
            'erreurCuisine' => 'Erreur Cuisine',
            'erreurServeur' => 'Erreur Serveur',
            'erreurCaisse' => 'Erreur Caisse',
            'perteEmporte' => 'Perte Emporte',
            'giveawayPizza' => 'Giveaway Pizza',
            'giveawayPasta' => 'Giveaway Pasta',
            'glovoE' => 'Glovo Espèce',
            'glovoC' => 'Glovo Carte',
            'appE' => 'App Espèce',
            'appC' => 'App Carte',
            'shooting' => 'Shooting',
            'ComGlovo' => 'Commission Glovo',
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
    
    public static function getFormattedTableColumns(): array
    {
        return [
            // Optionally format specific columns if needed
            'date' => fn (ClotureCaisse $record): string => $record->date->format('d/m/Y'),
            'montant' => fn (ClotureCaisse $record): string => number_format($record->montant, 2) . ' MAD',
            // Add other formatting as needed
        ];
    }
}