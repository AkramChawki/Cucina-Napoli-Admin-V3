<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BLResource\Pages;
use App\Models\BL;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class BLResource extends Resource
{
    protected static ?string $model = BL::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Economat';

    protected static ?string $modelLabel = 'BL Economat';

    protected static ?int $navigationSort = 2;

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
                    ->url(fn(BL $record): string => "https://restaurant.cucinanapoli.com/storage/bl/$record->pdf")
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-document'),
                Action::make("voir")
                    ->label('Voir')
                    ->url(fn(BL $record): string => BLResource::getUrl("details", ["record" => $record]))
                    ->icon('heroicon-o-eye'),
                Tables\Actions\DeleteAction::make()
                    ->after(function (BL $record) {
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

    public static function canCreate(): bool
    {
        return false;
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBLS::route('/'),
            'create' => Pages\CreateBL::route('/create'),
            'edit' => Pages\EditBL::route('/{record}/edit'),
            'details' => Pages\BLDetails::route('/{record}/details'),
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
