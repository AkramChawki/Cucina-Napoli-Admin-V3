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
use Filament\Support\Enums\MaxWidth;
use Illuminate\Contracts\View\View;

class ProduitNonConformeResource extends Resource
{
    protected static ?string $model = ProduitNonConforme::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';

    protected static ?string $navigationGroup = 'QHPSA';

    protected static ?string $modelLabel = 'Produit Non Conforme';

    protected static ?int $navigationSort = 6;

    // Restaurant domain constant
    protected const RESTAURANT_DOMAIN = 'https://restaurant.cucinanapoli.com/storage/';

    public static function form(Form $form): Form
    {
        return $form->schema([]);
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
                Tables\Columns\ViewColumn::make('images')
                    ->label('Photos')
                    ->view('filament.tables.columns.images-preview')
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                Action::make("pdf")
                    ->label('PDF')
                    ->url(fn (ProduitNonConforme $record): string => 
                        self::RESTAURANT_DOMAIN . "produits-non-conformes/{$record->pdf}")
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-document'),
                
                Action::make('view_images')
                    ->label('Photos')
                    ->icon('heroicon-o-photograph')
                    ->visible(fn (ProduitNonConforme $record): bool => 
                        $record->images && count($record->images) > 0)
                    ->modalContent(fn (ProduitNonConforme $record): View => view(
                        'filament.pages.pnc-images-modal',
                        [
                            'images' => collect($record->images)->map(fn ($path) => 
                                self::RESTAURANT_DOMAIN . $path)
                        ]
                    ))
                    ->modalWidth(MaxWidth::SevenExtraLarge),
                
                Tables\Actions\DeleteAction::make()
                    ->after(function (ProduitNonConforme $record) {
                        if ($record->pdf) {
                            try {
                                Storage::disk('public')->delete("produits-non-conformes/{$record->pdf}");
                            } catch (\Exception $e) {
                                report($e);
                            }
                        }
                        
                        if ($record->images) {
                            foreach ($record->images as $imagePath) {
                                try {
                                    Storage::disk('public')->delete($imagePath);
                                } catch (\Exception $e) {
                                    report($e);
                                }
                            }
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->after(function (Collection $records) {
                        foreach ($records as $record) {
                            if ($record->pdf) {
                                try {
                                    Storage::disk('public')->delete("produits-non-conformes/{$record->pdf}");
                                } catch (\Exception $e) {
                                    report($e);
                                }
                            }
                            
                            if ($record->images) {
                                foreach ($record->images as $imagePath) {
                                    try {
                                        Storage::disk('public')->delete($imagePath);
                                    } catch (\Exception $e) {
                                        report($e);
                                    }
                                }
                            }
                        }
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
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