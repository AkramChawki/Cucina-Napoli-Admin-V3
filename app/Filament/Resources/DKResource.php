<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DKResource\Pages;
use App\Models\DK;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class DKResource extends Resource
{
    protected static ?string $model = DK::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'flux de denrées';
    protected static ?string $modelLabel = 'Labo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('restau')
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
                    ->label("Commande Par :")
                    ->searchable(),
                Tables\Columns\TextColumn::make('restau')
                    ->label("Restaurant")
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label("Date de Commande")
                    ->date(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Action::make("pdf")
                    ->label('pdf')
                    ->url(fn(DK $record): string => "https://restaurant.cucinanapoli.com/storage/dk/$record->pdf")
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-document'),
                Action::make("voir")
                    ->label('Voir')
                    ->url(fn(DK $record): string => DKResource::getUrl("details", ["record" => $record]))
                    ->icon('heroicon-o-eye'),
                Tables\Actions\DeleteAction::make()
                    ->after(function (DK $record) {
                        $filesToDelete = array_filter([$record->pdf]);
                        if (!empty($filesToDelete)) {
                            Storage::disk('public')->delete($filesToDelete);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->after(function (Collection $records) {
                        $filesToDelete = $records->flatMap(function ($record) {
                            return array_filter([$record->pdf]);
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
            'index' => Pages\ListDKS::route('/'),
            'create' => Pages\CreateDK::route('/create'),
            'edit' => Pages\EditDK::route('/{record}/edit'),
            'details' => Pages\DKDetails::route('/{record}/details'),

        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && (
            $user->email == "admin@cucinanapoli.com" ||
            $user->email == "nimane@cucinanapoli.com" ||
            $user->email == "mmalika@cucinanapoli.com" ||
            $user->email == "nyoussef@cucinanapoli.com" ||
            $user->email == "oilham@cucinanapoli.com"
        );
    }
}