<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FicheResource\Pages;
use App\Models\CuisinierProduct;
use App\Models\Fiche;
use App\Models\Rubrique;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Support\Facades\DB;

class FicheResource extends Resource
{
    protected static ?string $model = Fiche::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'flux de denrées';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                    Forms\Components\Select::make('rubrique_id')
                    ->options(Rubrique::all()->pluck("title", "id"))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label("Nom")
                    ->searchable(),
                Tables\Columns\TextColumn::make('rubrique.title')
                    ->label("Rubrique")
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make("ajoute")
                    ->icon("heroicon-o-plus")
                    ->mountUsing(fn (Forms\ComponentContainer $form, Fiche $record) => $form->fill([
                        'fiche_id' => $record->id,
                    ]))
                    ->action(function (Fiche $record, array $data): void {
                        foreach ($data["cuisinier_product_ids"] as $product_id) {
                            DB::insert('insert into fiche_cuisinier_product (cuisinier_product_id, 	fiche_id) values (?, ?)', [$product_id, $record->id]);
                        }
                    })
                    ->form([
                        Forms\Components\Select::make('cuisinier_product_ids')
                            ->label('produit')
                            ->options(CuisinierProduct::query()->pluck('designation', 'id'))
                            ->required()
                            ->multiple()
                            ->searchable(),
                        Forms\Components\Select::make('fiche_id')
                            ->label('fiche')
                            ->options(Fiche::query()->pluck('name', 'id'))
                            ->required()
                            ->disabled(),
                    ]),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListFiches::route('/'),
            'create' => Pages\CreateFiche::route('/create'),
            'edit' => Pages\EditFiche::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && (
            $user->email == "admin@cucinanapoli.com" ||
            $user->email == "mmalika@cucinanapoli.com"
        );
    }
}
