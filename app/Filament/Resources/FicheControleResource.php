<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FicheControleResource\Pages;
use App\Models\FicheControle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class FicheControleResource extends Resource
{
    protected static ?string $model = FicheControle::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Controle De Gestion';

    protected static ?string $modelLabel = 'Fiche de Contrôle';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Fait Par')
                    ->searchable(),
                Tables\Columns\TextColumn::make('restau')
                    ->label('Restaurant')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Action::make('pdf')
                    ->label('pdf')
                    ->url(fn(FicheControle $record): string => "https://restaurant.cucinanapoli.com/storage/fiche-controles/$record->pdf")
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-document'),
                Tables\Actions\DeleteAction::make()
                    ->after(function (FicheControle $record) {
                        if ($record->pdf) {
                            Storage::disk('public')->delete($record->pdf);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->after(function (Collection $records) {
                        $filesToDelete = $records->map(function ($record) {
                            return $record->pdf;
                        })->filter()->values()->all();

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
            'index' => Pages\ListFicheControles::route('/'),
            'create' => Pages\CreateFicheControle::route('/create'),
            'edit' => Pages\EditFicheControle::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && (
            $user->email == "admin@cucinanapoli.com" ||
            $user->email == "nimane@cucinanapoli.com" ||
            $user->email == "nyassin@cucinanapoli.com" ||
            $user->email == "nyoussef@cucinanapoli.com" 
        );
    }
}