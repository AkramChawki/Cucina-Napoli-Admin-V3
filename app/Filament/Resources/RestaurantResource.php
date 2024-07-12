<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RestaurantResource\Pages;
use App\Models\Restaurant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class RestaurantResource extends Resource
{
    protected static ?string $model = Restaurant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'flux de denrées';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label("Nom")
                    ->required()
                    ->lazy()
                    ->maxLength(255)
                    ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', str::slug($state)) : null),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(Restaurant::class, 'slug', ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('telephone')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('localisation')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('storeID')
                    ->label("Store ID")
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tokenApi')
                    ->label("Token API")
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->columnSpan("full")
                    ->image()
                    ->directory("Restaurant")
                    ->required(),
                Forms\Components\FileUpload::make('image1')
                    ->image()
                    ->directory("Restaurant")
                    ->required(),
                Forms\Components\FileUpload::make('image2')
                    ->image()
                    ->directory("Restaurant")
                    ->required(),
                Forms\Components\RichEditor::make('Primary')
                    ->columnSpan("full")
                    ->label("Premier Text")
                    ->required(),
                Forms\Components\RichEditor::make('Secondary')
                    ->columnSpan("full")
                    ->label("deuxieme Text")
                    ->required(),
                Forms\Components\Select::make('quartiers')
                    ->label("Quartiers ou la livraison est accepte...")
                    ->multiple()
                    ->options(config("quartiers"))
                    ->required(),
                Forms\Components\Select::make('quartiers_Permitted')
                    ->label("Quartiers ou la livraison est accepte a partir de 300dh...")
                    ->multiple()
                    ->options(config("quartiers"))
                    ->required(),
                Forms\Components\Toggle::make('visible')
                    ->onColor('success')
                    ->offColor('danger')
                    ->inline(false)
                    ->required(),
                Forms\Components\TextInput::make('avis')
                    ->label("Lien des Avis Google")
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->square(),
                Tables\Columns\TextColumn::make('name')
                    ->label("Nom")
                    ->searchable(),
                Tables\Columns\TextColumn::make('telephone')
                    ->searchable(),
                Tables\Columns\IconColumn::make('visible')
                    ->boolean()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRestaurants::route('/'),
            'create' => Pages\CreateRestaurant::route('/create'),
            'edit' => Pages\EditRestaurant::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->email == "admin@cucinanapoli.com";
    }
}
