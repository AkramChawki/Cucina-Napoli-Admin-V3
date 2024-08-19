<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ControleResource\Pages;
use App\Models\Controle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;

class ControleResource extends Resource
{
    protected static ?string $model = Controle::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'flux de denrées';

    protected static ?string $modelLabel = 'Controle Interne';

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
                ->url(fn (Controle $record): string => "https://restaurant.cucinanapoli.com/storage/inventire/$record->pdf")
                ->openUrlInNewTab()
                ->icon('heroicon-o-document'),
            Action::make("voir")
                ->label('Voir')
                ->url(fn (Controle $record): string => ControleResource::getUrl("details", ["record" => $record]))
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
            'index' => Pages\ListControles::route('/'),
            'create' => Pages\CreateControle::route('/create'),
            'edit' => Pages\EditControle::route('/{record}/edit'),
            'details' => Pages\ControleDetails::route('/{record}/details'),

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
            $user->email == "oilham@cucinanapoli.com"
        );
    }
}
