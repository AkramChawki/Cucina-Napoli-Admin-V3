<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BMLResource\Pages;
use App\Models\BML;
use App\Models\Restaurant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BMLResource extends Resource
{
    protected static ?string $model = BML::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Restaurant Management';
    protected static ?int $navigationSort = 5;
    protected static ?string $modelLabel = 'BML';

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
                        Forms\Components\Select::make('month')
                            ->options(array_combine(range(1, 12), [
                                'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                                'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
                            ]))
                            ->required(),
                            
                        Forms\Components\Select::make('year')
                            ->options(array_combine(range(date('Y')-1, date('Y')+1), range(date('Y')-1, date('Y')+1)))
                            ->required(),

                        Forms\Components\DatePicker::make('date')
                            ->required()
                            ->format('Y-m-d'),

                        Forms\Components\Select::make('type')
                            ->label('Type')
                            ->options(BML::TYPES)
                            ->required(),
                    ]),
                    
                Forms\Components\TextInput::make('fournisseur')
                    ->label('Fournisseur')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('designation')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('quantity')
                            ->label('Quantité')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->step('0.01')
                            ->reactive(),
                            
                        Forms\Components\TextInput::make('unite')
                            ->label('Unité')
                            ->required(),

                        Forms\Components\TextInput::make('price')
                            ->label('Prix')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->step('0.01')
                            ->suffix('MAD')
                            ->reactive(),

                        Forms\Components\TextInput::make('total_ttc')
                            ->label('Total TTC')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(true)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                // This was incorrect in the original code
                                $quantity = $get('quantity') ?? 0;
                                $price = $get('price') ?? 0;
                                $set('total_ttc', $quantity * $price);
                            })
                            ->suffix('MAD'),
                    ]),
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
                    
                Tables\Columns\TextColumn::make('date')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->formatStateUsing(fn ($state) => array_flip(BML::TYPES)[$state] ?? $state)
                    ->sortable(),
                    
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
                    
                Tables\Columns\TextColumn::make('fournisseur')
                    ->label('Fournisseur')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('designation')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Quantité')
                    ->numeric(2)
                    ->sortable(),

                Tables\Columns\TextColumn::make('unite')
                    ->label('Unité')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('price')
                    ->label('Prix')
                    ->money('eur')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_ttc')
                    ->label('Total TTC')
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
                    ->options(BML::TYPES),
                    
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
            'index' => Pages\ListBMLs::route('/'),
            'create' => Pages\CreateBML::route('/create'),
            'edit' => Pages\EditBML::route('/{record}/edit'),
        ];
    }
}