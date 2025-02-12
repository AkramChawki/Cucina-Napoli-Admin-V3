<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InfractionResource\Pages;
use App\Filament\Resources\InfractionResource\RelationManagers;
use App\Models\Infraction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InfractionResource extends Resource
{
    protected static ?string $model = Infraction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'CRM';

    protected static ?string $modelLabel = 'Infractions';

    protected static ?int $navigationSort = 4;

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
                Tables\Columns\TextColumn::make('restaurant')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('poste')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('employe.first_name')
                    ->label('Employé')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('infraction_constatee')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('infraction_date')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('infraction_time')
                    ->time('H:i')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('photo_path')
                    ->label('Photo'),
            ])
            ->filters([
                SelectFilter::make('restaurant')
                    ->options([
                        'Palmier' => 'Palmier',
                        'Anoual' => 'Anoual',
                        'Labo' => 'Labo',
                        'Economat' => 'Economat',
                        'Ziraoui' => 'Ziraoui',
                    ]),
                SelectFilter::make('employe')
                    ->relationship('employe', 'first_name'),
                Filter::make('infraction_date')
                    ->form([
                        Forms\Components\DatePicker::make('from'),
                        Forms\Components\DatePicker::make('until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('infraction_date', '>=', $date),
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('infraction_date', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalContent(fn ($record) => view('filament.resources.infraction.modal', [
                        'imageUrl' => "https://restaurant.cucinanapoli.com/storage/infractions/{$record->photo_path}"
                    ])),
                    Tables\Actions\Action::make('pdf')
                    ->label('PDF')
                    ->url(fn ($record): string => "https://restaurant.cucinanapoli.com/storage/{$record->pdf}")
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-document'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListInfractions::route('/'),
            'create' => Pages\CreateInfraction::route('/create'),
            'edit' => Pages\EditInfraction::route('/{record}/edit'),
        ];
    }
}
