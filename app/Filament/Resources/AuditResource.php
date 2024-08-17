<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuditResource\Pages;
use App\Filament\Resources\AuditResource\RelationManagers;
use App\Models\Audit;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;


class AuditResource extends Resource
{
    protected static ?string $model = Audit::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Gestion Restaurant';

    protected static ?int $navigationSort = 3;

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
                ->label("Audit Par :")
                ->searchable(),
            Tables\Columns\TextColumn::make('restau')
                ->label("Restaurant")
                ->searchable(),
            Tables\Columns\TextColumn::make('date')
                ->label("Date d Audit")
                ->date(),
        ])
        ->defaultSort('created_at', 'desc')
        ->filters([
            //
        ])
        ->actions([
            Action::make("image")
                    ->label('image')
                    ->url(fn(Audit $record): string => "https://restaurant.cucinanapoli.com/storage/documents/$record->image")
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-document')
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
            'index' => Pages\ListAudits::route('/'),
            'create' => Pages\CreateAudit::route('/create'),
            'edit' => Pages\EditAudit::route('/{record}/edit'),
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
