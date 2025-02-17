<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventaireResource\Pages;
use App\Models\Inventaire;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class InventaireResource extends Resource
{
    protected static ?string $model = Inventaire::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Inventaire';

    protected static ?string $modelLabel = 'Inventaire Economat';


    protected static ?int $navigationSort = 9;

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
                ->url(fn (Inventaire $record): string => "https://restaurant.cucinanapoli.com/storage/inventaire/$record->pdf")
                ->openUrlInNewTab()
                ->icon('heroicon-o-document'),
            Action::make("voir")
                ->label('Voir')
                ->url(fn (Inventaire $record): string => InventaireResource::getUrl("details", ["record" => $record]))
                ->icon('heroicon-o-eye'),
            Tables\Actions\DeleteAction::make()
                    ->after(function (Inventaire $record) {
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
            'index' => Pages\ListInventaires::route('/'),
            'create' => Pages\CreateInventaire::route('/create'),
            'edit' => Pages\EditInventaire::route('/{record}/edit'),
            'details' => Pages\InventaireDetails::route('/{record}/details'),
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
