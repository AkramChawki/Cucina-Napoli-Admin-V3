<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Category;
use App\Models\Product;
use App\Models\Restaurant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Gestion Site En Ligne';

    protected static ?string $modelLabel = 'Produits';


    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->lazy()
                    ->afterStateUpdated(fn(string $context, $state, callable $set) => $context === 'create' ? $set('slug', Str::slug($state)) : null),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(Product::class, 'slug', ignoreRecord: true),
                Forms\Components\RichEditor::make('text')
                    ->columnSpan("full")
                    ->required(),
                Forms\Components\TextInput::make('sub_name')
                    ->required(),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory("products")
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->options(Category::all()->pluck("name", "id"))
                    ->required(),
                Forms\Components\Select::make('restaurant')
                    ->multiple()
                    ->options(Restaurant::all()->pluck("name", "name")->mapWithKeys(function ($item, $key) {
                        return [Str::lower($key) => $item];
                    }))
                    ->required()
                    ->saveRelationshipsUsing(function ($record, $state) {
                        $record->restaurant = array_map(function ($item) {
                            return Str::lower($item);
                        }, $state);
                    }),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->required(),
                Forms\Components\Toggle::make('is_formule')
                    ->label('Est une formule')
                    ->helperText('Activer si ce produit est une formule avec des options'),
                Forms\Components\TextInput::make('IDCaisse')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->square(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label("Categorie")
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label("Nom")
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_formule')
                    ->label("Formule")
                    ->boolean(),
                Tables\Columns\TextColumn::make('restaurant')
                    ->separator(','),
                Tables\Columns\TextColumn::make('price')
                    ->label("Prix"),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->after(function (Product $record) {
                        $filesToDelete = array_filter([$record->image]);
                        if (!empty($filesToDelete)) {
                            Storage::disk('public')->delete($filesToDelete);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->after(function (Collection $records) {
                        $filesToDelete = $records->flatMap(function ($record) {
                            return array_filter([$record->image]);
                        })->values()->all();

                        if (!empty($filesToDelete)) {
                            Storage::disk('public')->delete($filesToDelete);
                        }
                    }),

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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && (
            $user->email == "admin@cucinanapoli.com" ||
            $user->email == "nimane@cucinanapoli.com"
        );
    }
}