<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PresenceResource\Pages;
use App\Models\Presence;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;


class PresenceResource extends Resource
{
    protected static ?string $model = Presence::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'RH';

    protected static ?string $modelLabel = 'Présence';

    protected static ?int $navigationSort = 2;

    protected static array $restaurants = [
        'anoual' => 'Anoual',
        'palmier' => 'Palmier',
        'ziraoui' => 'Ziraoui',
        'togo' => 'To Go',
    ];

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employe.first_name')
                    ->label('Prénom')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('employe.last_name')
                    ->label('Nom')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('employe.restau')
                    ->label('Restaurant')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('month')
                    ->label('Mois')
                    ->formatStateUsing(fn(int $state): string => [
                        1 => 'Janvier',
                        2 => 'Février',
                        3 => 'Mars',
                        4 => 'Avril',
                        5 => 'Mai',
                        6 => 'Juin',
                        7 => 'Juillet',
                        8 => 'Août',
                        9 => 'Septembre',
                        10 => 'Octobre',
                        11 => 'Novembre',
                        12 => 'Décembre',
                    ][$state])
                    ->sortable(),

                Tables\Columns\TextColumn::make('year')
                    ->label('Année')
                    ->sortable(),

                Tables\Columns\TextColumn::make('jours')
                    ->label('Jours')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('month')
                    ->label('Month')
                    ->options(
                        collect(range(1, 12))
                            ->mapWithKeys(fn($month) => [$month => date('F', mktime(0, 0, 0, $month, 1))])
                            ->toArray()
                    ),

                // Year filter
                SelectFilter::make('year')
                    ->label('Year')
                    ->options(
                        fn() => Presence::query()
                            ->select('year')
                            ->distinct()
                            ->orderBy('year', 'desc')
                            ->pluck('year', 'year')
                            ->toArray()
                    ),
            ])
            ->actions([
                Tables\Actions\Action::make('view_attendance')
                    ->label('Voir présence')
                    ->icon('heroicon-o-eye')
                    ->url(fn(Presence $record) => route('filament.admin.resources.presences.view-attendance', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                ExportBulkAction::make()
            ])
            ->persistSortInSession();
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPresences::route('/'),
            'view-attendance' => Pages\ViewAttendance::route('/{record}/attendance'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
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
