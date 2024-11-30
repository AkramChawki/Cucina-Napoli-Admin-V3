<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CuisinierProductResource\Pages;
use App\Models\CuisinierCategory;
use App\Models\CuisinierProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class CuisinierProductResource extends Resource
{
    protected static ?string $model = CuisinierProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Tools';

    protected static ?string $modelLabel = 'Produits Cuisinier';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('cuisinier_category_id')
                    ->label("Category")
                    ->options(CuisinierCategory::all()->pluck("name", "id"))
                    ->required(),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory("cuisinier_products")
                    ->required(),
                Forms\Components\TextInput::make('designation')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('unite')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->label("Charge de livraison")
                    ->options(config("livraison"))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->square(),
                Tables\Columns\TextColumn::make('designation')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unite'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->after(function (CuisinierProduct $record) {
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
            'index' => Pages\ListCuisinierProducts::route('/'),
            'create' => Pages\CreateCuisinierProduct::route('/create'),
            'edit' => Pages\EditCuisinierProduct::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && (
            $user->email == "admin@cucinanapoli.com" ||
            $user->email == "nimane@cucinanapoli.com" ||
            $user->email == "mmalika@cucinanapoli.com" ||
            $user->email == "nyoussef@cucinanapoli.com" ||
            $user->email == "oilham@cucinanapoli.com" ||
            $user->email == "dmeriem@cucinanapoli.com" ||
            $user->email == "afatima@cucinanapoli.com"
        );
    }
}
