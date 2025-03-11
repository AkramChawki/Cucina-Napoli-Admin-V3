<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClotureCaisseResource\Pages;
use App\Models\ClotureCaisse;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Exports\ClotureCaisseExporter;

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
                Card::make()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nom')
                                    ->required(),
                                TextInput::make('restau')
                                    ->label('Restaurant')
                                    ->required(),
                                DatePicker::make('date')
                                    ->required(),
                                TimePicker::make('time')
                                    ->required(),
                                TextInput::make('responsable')
                                    ->required(),
                                TextInput::make('montant')
                                    ->label('Montant Total')
                                    ->numeric()
                                    ->required(),
                                TextInput::make('montantE')
                                    ->label('Montant Espèce')
                                    ->numeric(),
                                TextInput::make('cartebancaire')
                                    ->label('Carte Bancaire')
                                    ->numeric(),
                                TextInput::make('cartebancaireLivraison')
                                    ->label('CB Livraison')
                                    ->numeric(),
                                TextInput::make('virement')
                                    ->numeric(),
                                TextInput::make('cheque')
                                    ->numeric(),
                                TextInput::make('compensation')
                                    ->numeric(),
                                TextInput::make('familleAcc')
                                    ->label('Famille & Accompagnant')
                                    ->numeric(),
                                TextInput::make('erreurPizza')
                                    ->label('Erreur Pizza')
                                    ->numeric(),
                                TextInput::make('erreurCuisine')
                                    ->label('Erreur Cuisine')
                                    ->numeric(),
                                TextInput::make('erreurServeur')
                                    ->label('Erreur Serveur')
                                    ->numeric(),
                                TextInput::make('erreurCaisse')
                                    ->label('Erreur Caisse')
                                    ->numeric(),
                                TextInput::make('perteEmporte')
                                    ->label('Perte Emporte')
                                    ->numeric(),
                                TextInput::make('giveawayPizza')
                                    ->numeric(),
                                TextInput::make('giveawayPasta')
                                    ->numeric(),
                                TextInput::make('glovoE')
                                    ->label('Glovo Espèce')
                                    ->numeric(),
                                TextInput::make('glovoC')
                                    ->label('Glovo Carte')
                                    ->numeric(),
                                TextInput::make('appE')
                                    ->label('App Espèce')
                                    ->numeric(),
                                TextInput::make('appC')
                                    ->label('App Carte')
                                    ->numeric(),
                                TextInput::make('shooting')
                                    ->numeric(),
                                TextInput::make('ComGlovo')
                                    ->label('Commission Glovo')
                                    ->numeric()
                                    ->disabled(),
                            ])
                    ])
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

                Tables\Columns\TextColumn::make('responsable')
                    ->searchable()
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
                    ->exporter(
                        ClotureCaisseExporter::class,
                    )
            ]);
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
    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && (
            $user->email == "admin@cucinanapoli.com" ||
            $user->email == "nimane@cucinanapoli.com" ||
            $user->email == "bfati@cucinanapoli.com"

        );
    }
}