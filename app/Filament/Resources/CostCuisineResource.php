<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CostCuisineResource\Pages;
use App\Models\CostCuisine;
use App\Models\Restaurant;
use App\Models\CuisinierProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CostCuisineResource extends Resource
{
    protected static ?string $model = CostCuisine::class;
    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationGroup = 'Restaurant Management';
    protected static ?int $navigationSort = 4;
    protected static ?string $modelLabel = 'Cost Cuisine';

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
                    ->options(fn () => CuisinierProduct::whereHas('fiches', function ($query) {
                        $query->where('fiche_id', 1);
                    })->pluck('designation', 'id'))
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
                    
                Tables\Columns\TextColumn::make('value')
                    ->sortable()
                    ->numeric(2),
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
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCostCuisines::route('/'),
            'create' => Pages\CreateCostCuisine::route('/create'),
            'edit' => Pages\EditCostCuisine::route('/{record}/edit'),
        ];
    }
}