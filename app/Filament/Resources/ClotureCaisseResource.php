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
use Filament\Forms\Components\Grid;

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
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('time')
                    ->time()
                    ->sortable(),

                Tables\Columns\TextColumn::make('montant')
                    ->label('Montant Caisse')
                    ->money('mad')
                    ->sortable(),

                Tables\Columns\TextColumn::make('montantE')
                    ->label('Montant Espèce')
                    ->money('mad')
                    ->sortable(),

                Tables\Columns\TextColumn::make('ComGlovo')
                    ->label('Commission Glovo')
                    ->money('mad')
                    ->sortable(),

                Tables\Columns\TextColumn::make('ComLivraison')
                    ->label('Commission Livraison')
                    ->money('mad')
                    ->sortable(),

                Tables\Columns\ImageColumn::make('signature')
                    ->square(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('restau')
                    ->label('Restaurant')
                    ->options(fn () => ClotureCaisse::distinct()->pluck('restau', 'restau')->toArray()),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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