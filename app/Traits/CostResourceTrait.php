<?php

namespace App\Traits;

use App\Models\Restaurant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

trait CostResourceTrait
{
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('restaurant_id')
                    ->label('Restaurant')
                    ->options(Restaurant::pluck('name', 'id'))
                    ->required()
                    ->searchable(),
                    
                Forms\Components\Select::make('product_id')
                    ->label('Product')
                    ->options(static::getProductOptions())
                    ->required()
                    ->searchable(),
                    
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Select::make('month')
                            ->options(array_combine(range(1, 12), [
                                'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                                'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
                            ]))
                            ->required(),
                            
                        Forms\Components\Select::make('year')
                            ->options(array_combine(range(date('Y')-1, date('Y')+1), range(date('Y')-1, date('Y')+1)))
                            ->required(),
                            
                        Forms\Components\Select::make('day')
                            ->options(array_combine(range(1, 31), range(1, 31)))
                            ->required(),

                        Forms\Components\Select::make('period')
                            ->options([
                                'morning' => 'Matin',
                                'afternoon' => 'Midi'
                            ])
                            ->required(),
                    ]),
                    
                Forms\Components\TextInput::make('value')
                    ->label('Value')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->step('0.01'),
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
                    
                Tables\Columns\TextColumn::make('product.designation')
                    ->label('Product')
                    ->sortable()
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('month')
                    ->formatStateUsing(fn ($state) => [
                        1 => 'Janvier', 2 => 'Février', 3 => 'Mars',
                        4 => 'Avril', 5 => 'Mai', 6 => 'Juin',
                        7 => 'Juillet', 8 => 'Août', 9 => 'Septembre',
                        10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
                    ][$state])
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('year')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('day')
                    ->sortable(),

                Tables\Columns\TextColumn::make('period')
                    ->formatStateUsing(fn ($state) => [
                        'morning' => 'Matin',
                        'afternoon' => 'Midi'
                    ][$state])
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('value')
                    ->sortable()
                    ->money('eur'),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('restaurant')
                    ->relationship('restaurant', 'name'),
                    
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
}