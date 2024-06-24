<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CuisinierInventaireResource\Pages;
use App\Models\CuisinierInventaire;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;


class CuisinierInventaireResource extends Resource
{
    protected static ?string $model = CuisinierInventaire::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'flux de denrées';

    protected static ?string $modelLabel = 'Inventaire Chiffrés';


    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('restau')
                    ->label("Restaurant")
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('product_ids')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label("Inventaiire Par :")
                    ->searchable(),
                Tables\Columns\TextColumn::make('restau')
                    ->label("Restaurant")
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label("Date d inventaire")
                    ->date(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Action::make("pdf")
                    ->label('pdf')
                    ->url(fn (CuisinierInventaire $record): string => "https://restaurant.cucinanapoli.com/storage/documents/$record->pdf")
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-document'),
                Action::make("voir")
                    ->label('Voir')
                    ->url(fn (CuisinierInventaire $record): string => CuisinierInventaireResource::getUrl("details", ["record" => $record]))
                    ->icon('heroicon-o-eye')
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

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCuisinierInventaires::route('/'),
            'create' => Pages\CreateCuisinierInventaire::route('/create'),
            'edit' => Pages\EditCuisinierInventaire::route('/{record}/edit'),
            'details' => Pages\CuisinierInventaireDetails::route('/{record}/details'),

        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->email == "admin@cucinanapoli.com";
    }
}
