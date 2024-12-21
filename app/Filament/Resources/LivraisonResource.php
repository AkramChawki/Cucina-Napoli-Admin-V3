<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LivraisonResource\Pages;
use App\Models\Livraison;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class LivraisonResource extends Resource
{
    protected static ?string $model = Livraison::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Flux Restaurant';
    protected static ?string $modelLabel = 'Livraisons';
    protected static ?int $navigationSort = 11;

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
            Tables\Columns\TextColumn::make('type')
                ->label("Type de BL")
                ->searchable(),
            Tables\Columns\TextColumn::make('restaurant_group')
                ->label("Restaurant")
                ->searchable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label("Date de Commande")
                ->dateTime()
                ->sortable(),
        ])
        ->defaultSort('created_at', 'desc')
        ->filters([
            Tables\Filters\SelectFilter::make('type')
                ->label('Type de BL')
                ->options(config('livraison')),
            Tables\Filters\SelectFilter::make('restaurant_group')
                ->label('Restaurant')
                ->options([
                    'Anoual' => 'Anoual',
                    'Palmier' => 'Palmier',
                    'Ziraoui' => 'Ziraoui',
                    'To Go' => 'To Go',
                    'Labo' => 'Labo',
                ]),
        ])
        ->actions([
            Action::make("pdf")
                ->label('pdf')
                ->url(fn(Livraison $record): string => $record->pdf_url)
                ->openUrlInNewTab()
                ->icon('heroicon-o-document'),
            Tables\Actions\DeleteAction::make()
                ->after(function (Livraison $record) {
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
            'index' => Pages\ListLivraisons::route('/'),
            'create' => Pages\CreateLivraison::route('/create'),
            'edit' => Pages\EditLivraison::route('/{record}/edit'),
        ];
    }
    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && (
            $user->email == "admin@cucinanapoli.com" ||
            $user->email == "nimane@cucinanapoli.com" ||
            $user->email == "nyoussef@cucinanapoli.com"
        );
    }
}
