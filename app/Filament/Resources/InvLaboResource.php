<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvLaboResource\Pages;
use App\Filament\Resources\InvLaboResource\RelationManagers;
use App\Models\InvLabo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Collection;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Actions\Action;


class InvLaboResource extends Resource
{
    protected static ?string $model = InvLabo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Inventaire';

    protected static ?string $modelLabel = 'Inventaire Labo';

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
                    ->url(fn(InvLabo $record): string => "https://restaurant.cucinanapoli.com/storage/inventaire/$record->pdf")
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-document'),
                Action::make("voir")
                    ->label('Voir')
                    ->url(fn(InvLabo $record): string => InvLaboResource::getUrl("details", ["record" => $record]))
                    ->icon('heroicon-o-eye'),
                Tables\Actions\DeleteAction::make()
                    ->after(function (InvLabo $record) {
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

    public static function canCreate(): bool
    {
        return false;
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
            'index' => Pages\ListInvLabos::route('/'),
            'create' => Pages\CreateInvLabo::route('/create'),
            'edit' => Pages\EditInvLabo::route('/{record}/edit'),
            'details' => Pages\InvLaboDetails::route('/{record}/details'),

        ];
    }
}
