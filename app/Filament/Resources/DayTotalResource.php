<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DayTotalResource\Pages;
use App\Models\DayTotal;
use App\Models\Restaurant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DayTotalResource extends Resource
{
    protected static ?string $model = DayTotal::class;
    protected static ?string $navigationIcon = 'heroicon-o-calculator';
    protected static ?string $navigationGroup = 'Restaurant Management';
    protected static ?int $navigationSort = 6;
    protected static ?string $modelLabel = 'Daily Totals';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('restaurant_id')
                    ->label('Restaurant')
                    ->options(Restaurant::pluck('name', 'id'))
                    ->required()
                    ->searchable(),
                    
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('Type')
                            ->options([
                                DayTotal::TYPE_CONSOMMABLE => 'Consommable',
                                DayTotal::TYPE_CUISINE => 'Cuisine',
                                DayTotal::TYPE_ECONOMAT => 'Economat',
                                DayTotal::TYPE_PIZZA => 'Pizza',
                            ])
                            ->required(),
                            
                        Forms\Components\TextInput::make('day')
                            ->label('Day')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(31),
                            
                        Forms\Components\Select::make('month')
                            ->options(array_combine(range(1, 12), [
                                'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                                'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
                            ]))
                            ->required(),
                            
                        Forms\Components\Select::make('year')
                            ->options(array_combine(range(date('Y')-1, date('Y')+1), range(date('Y')-1, date('Y')+1)))
                            ->required(),
                    ]),
                    
                Forms\Components\TextInput::make('total')
                    ->label('Total')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->step('0.01')
                    ->suffix('€'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('restaurant.name')
                    ->label('Restaurant')
                    ->sortable()
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('type')
                    ->formatStateUsing(function ($state) {
                        $types = [
                            DayTotal::TYPE_CONSOMMABLE => 'Consommable',
                            DayTotal::TYPE_CUISINE => 'Cuisine',
                            DayTotal::TYPE_ECONOMAT => 'Economat',
                            DayTotal::TYPE_PIZZA => 'Pizza',
                        ];
                        
                        // Return the mapped value or the original state if not found
                        return $types[$state] ?? $state;
                    })
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('day')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('month')
                    ->formatStateUsing(function ($state) {
                        $months = [
                            1 => 'Janvier', 2 => 'Février', 3 => 'Mars',
                            4 => 'Avril', 5 => 'Mai', 6 => 'Juin',
                            7 => 'Juillet', 8 => 'Août', 9 => 'Septembre',
                            10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
                        ];
                        
                        return $months[$state] ?? $state;
                    })
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('year')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('eur')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('restaurant')
                    ->relationship('restaurant', 'name'),
                    
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        DayTotal::TYPE_CONSOMMABLE => 'Consommable',
                        DayTotal::TYPE_CUISINE => 'Cuisine',
                        DayTotal::TYPE_ECONOMAT => 'Economat',
                        DayTotal::TYPE_PIZZA => 'Pizza',
                    ]),
                    
                Tables\Filters\SelectFilter::make('month')
                    ->options([
                        1 => 'Janvier', 2 => 'Février', 3 => 'Mars',
                        4 => 'Avril', 5 => 'Mai', 6 => 'Juin',
                        7 => 'Juillet', 8 => 'Août', 9 => 'Septembre',
                        10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
                    ]),
                    
                Tables\Filters\Filter::make('year')
                    ->form([
                        Forms\Components\Select::make('year')
                            ->options(array_combine(range(date('Y')-1, date('Y')+1), range(date('Y')-1, date('Y')+1))),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['year'],
                            fn (Builder $query, $year): Builder => $query->where('year', $year),
                        );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListDayTotals::route('/'),
            'create' => Pages\CreateDayTotal::route('/create'),
            'edit' => Pages\EditDayTotal::route('/{record}/edit'),
        ];
    }
}