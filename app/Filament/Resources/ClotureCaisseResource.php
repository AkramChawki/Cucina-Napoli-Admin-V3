<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClotureCaisseResource\Pages;
use App\Models\ClotureCaisse;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\ExportBulkAction;

class ClotureCaisseResource extends Resource
{
    protected static ?string $model = ClotureCaisse::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Chiffre Affaire';

    protected static ?string $navigationLabel = 'Cloture de Caisse';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('restau')
                    ->label('Restaurant')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('date')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('montant')
                    ->label('Montant Caisse')
                    ->money('mad')
                    ->sortable()
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->money('mad'),
                    ]),

                Tables\Columns\TextColumn::make('montantE')
                    ->label('Espèces')
                    ->money('mad')
                    ->sortable()
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->money('mad'),
                    ]),

                Tables\Columns\TextColumn::make('cartebancaire')
                    ->label('Carte Bancaire')
                    ->money('mad')
                    ->sortable()
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->money('mad'),
                    ]),

                Tables\Columns\TextColumn::make('ComGlovo')
                    ->label('Com. Glovo')
                    ->money('mad')
                    ->color('danger')
                    ->sortable()
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->money('mad'),
                    ]),

                Tables\Columns\TextColumn::make('ComLivraison')
                    ->label('Com. Livraison')
                    ->money('mad')
                    ->color('danger')
                    ->sortable()
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->money('mad'),
                    ]),
            ])
            ->defaultSort('date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('restau')
                    ->label('Restaurant')
                    ->options(fn() => ClotureCaisse::distinct()->pluck('restau', 'restau')->toArray())
                    ->multiple(),

                Tables\Filters\Filter::make('date')
                    ->form([
                        DatePicker::make('date_from')
                            ->label('Du'),
                        DatePicker::make('date_to')
                            ->label('Au'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['date_from'],
                                fn($query) => $query->whereDate('date', '>=', $data['date_from'])
                            )
                            ->when(
                                $data['date_to'],
                                fn($query) => $query->whereDate('date', '<=', $data['date_to'])
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->requiresConfirmation(),
                ExportBulkAction::make()

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClotureCaisses::route('/'),
            'create' => Pages\CreateClotureCaisse::route('/create'),
            'edit' => Pages\EditClotureCaisse::route('/{record}/edit'),
            'view' => Pages\ViewClotureCaisse::route('/{record}'),
        ];
    }
}
