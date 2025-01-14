<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProduitNonConformeResource\Pages;
use App\Models\ProduitNonConforme;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ProduitNonConformeResource extends Resource
{
    protected static ?string $model = ProduitNonConforme::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';

    protected static ?string $navigationGroup = 'QHPSA';

    protected static ?string $modelLabel = 'Produit Non Conforme';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label("Enregistré Par")
                    ->searchable(),
                Tables\Columns\TextColumn::make('restau')
                    ->label("Restaurant")
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label("Type")
                    ->searchable(),
                Tables\Columns\TextColumn::make('produit')
                    ->label("Produit")
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->label("Date")
                    ->date(),
                Tables\Columns\TextColumn::make('date_production')
                    ->label("Date Production")
                    ->date(),
                Tables\Columns\TextColumn::make('probleme')
                    ->label("Problème")
                    ->searchable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Action::make("pdf")
                    ->label('pdf')
                    ->url(fn(ProduitNonConforme $record): string => "https://restaurant.cucinanapoli.com/storage/produits-non-conformes/$record->pdf")
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-document'),
                Tables\Actions\DeleteAction::make()
                    ->after(function (ProduitNonConforme $record) {
                        if ($record->pdf) {
                            Storage::disk('public')->delete($record->pdf);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->after(function (Collection $records) {
                        $filesToDelete = $records->map(function ($record) {
                            return $record->pdf;
                        })->filter()->values()->all();

                        if (!empty($filesToDelete)) {
                            Storage::disk('public')->delete($filesToDelete);
                        }
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProduitNonConformes::route('/'),
            'create' => Pages\CreateProduitNonConforme::route('/create'),
            'edit' => Pages\EditProduitNonConforme::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && (
            $user->email == "admin@cucinanapoli.com" ||
            $user->email == "nimane@cucinanapoli.com" ||
            $user->email == "nyassin@cucinanapoli.com"
        );
    }
}