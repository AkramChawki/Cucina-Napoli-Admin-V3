<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PresenceResource\Pages;
use App\Models\Employe;
use App\Models\Presence;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PresenceResource extends Resource
{
    protected static ?string $model = Presence::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'RH';

    protected static ?string $modelLabel = 'Présence';

    protected static ?int $navigationSort = 2;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            // ->header(fn() => view('filament.resources.presence.header', [
            //     'restaurants' => DB::table('employes')
            //         ->select('restau')
            //         ->distinct()
            //         ->whereNotNull('restau')
            //         ->orderBy('restau')
            //         ->pluck('restau')
            // ]))
            ->columns([
                Tables\Columns\TextColumn::make('employe.first_name')
                    ->label('Prénom')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('employe.last_name')
                    ->label('Nom')
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
            ->modifyQueryUsing(function (Builder $query) {
                if (request()->query('restaurant')) {
                    $query->whereHas('employe', function ($q) {
                        $q->where('restau', request()->query('restaurant'));
                    });
                }
                return $query;
            })
            ->filters([
                SelectFilter::make('employe.restau')
                    ->label('Restaurant')
                    ->options(
                        fn() => Employe::query()
                            ->select('restau')
                            ->distinct()
                            ->whereNotNull('restau')
                            ->orderBy('restau')
                            ->pluck('restau', 'restau')
                            ->toArray()
                    )
                    ->query(function (Builder $query, $state) {
                        return $query->when(
                            $state,
                            fn($q) => $q->where('employes.restau', $state) // Ensure the table name is prefixed
                        );
                    }),




                SelectFilter::make('month')
                    ->label('Mois')
                    ->options([
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
                    ]),
                SelectFilter::make('year')
                    ->label('Année')
                    ->options(fn() => array_combine(
                        range(date('Y') - 2, date('Y')),
                        range(date('Y') - 2, date('Y'))
                    )),
            ])
            ->actions([
                Tables\Actions\Action::make('view_attendance')
                    ->label('Voir présence')
                    ->icon('heroicon-o-eye')
                    ->url(fn(Presence $record) => route('filament.admin.resources.presences.view-attendance', $record))
                    ->openUrlInNewTab(),
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
            $user->email == "nimane@cucinanapoli.com" ||
            $user->email == "basmaa@cucinanapoli.com" ||
            $user->email == "btayeb@cucinanapoli.com"
        );
    }
}
