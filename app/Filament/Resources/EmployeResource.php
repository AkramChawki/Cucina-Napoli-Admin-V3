<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeResource\Pages;
use App\Filament\Resources\EmployeResource\RelationManagers;
use App\Models\Employe;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeResource extends Resource
{
    protected static ?string $model = Employe::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'CRM';

    protected static ?string $modelLabel = 'Employe';

    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations Personnelles')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->label('Prénom')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('last_name')
                            ->label('Nom')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('DDN')
                            ->label('Date de Naissance')
                            ->required()
                            ->maxDate(now()->subYears(18)),
                        Forms\Components\TextInput::make('telephone')
                            ->label('Téléphone')
                            ->required()
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\Select::make('marital_status')
                            ->label('Situation Familiale')
                            ->options([
                                'single' => 'Célibataire',
                                'married' => 'Marié(e)',
                                'other' => 'Autre'
                            ])
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Adresse')
                    ->schema([
                        Forms\Components\TextInput::make('address')
                            ->label('Adresse')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('city')
                            ->label('Ville')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('country')
                            ->label('Pays')
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Information Professionnelle')
                    ->schema([
                        Forms\Components\TextInput::make('username')
                            ->label('Nom d\'utilisateur')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->suffixIcon('heroicon-m-at-symbol')
                            ->suffix('@cucinanapoli.com'),
                        Forms\Components\TextInput::make('restau')
                            ->label('Restaurant')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('embauche')
                            ->label('Date d\'embauche')
                            ->required(),
                        Forms\Components\DatePicker::make('depart')
                            ->label('Date de départ')
                            ->nullable(),
                    ])->columns(2),

                Forms\Components\Section::make('Documents')
                    ->schema([
                        Forms\Components\FileUpload::make('profile_photo')
                            ->label('Photo de profil')
                            ->image()
                            ->imageEditor()
                            ->disk('restaurant')
                            ->directory('storage/profile-photos')
                            ->maxSize(10240)
                            ->nullable(),

                        Forms\Components\FileUpload::make('id_card_front')
                            ->label('CIN Recto')
                            ->image()
                            ->disk('restaurant')
                            ->directory('storage/id-cards')
                            ->required()
                            ->maxSize(10240),

                        Forms\Components\FileUpload::make('id_card_back')
                            ->label('CIN Verso')
                            ->image()
                            ->disk('restaurant')
                            ->directory('storage/id-cards')
                            ->required()
                            ->maxSize(10240),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('profile_photo')
                    ->label('Photo')
                    ->circular(),
                Tables\Columns\TextColumn::make('first_name')
                    ->label('Prénom')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('telephone')
                    ->label('Téléphone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('restau')
                    ->label('Restaurant')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('embauche')
                    ->label('Date d\'embauche')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('depart')
                    ->label('Date de départ')
                    ->date()
                    ->sortable()
                    ->placeholder('En service'),
            ])
            ->filters([
                SelectFilter::make('restau')
                    ->label('Restaurant')
                    ->options(fn() => Employe::distinct()->pluck('restau', 'restau')->toArray()),
                SelectFilter::make('marital_status')
                    ->label('Situation Familiale')
                    ->options([
                        'single' => 'Célibataire',
                        'married' => 'Marié(e)',
                        'other' => 'Autre'
                    ]),
                Tables\Filters\TernaryFilter::make('depart')
                    ->label('Statut')
                    ->placeholder('Tous les employés')
                    ->trueLabel('Anciens employés')
                    ->falseLabel('Employés actifs')
                    ->queries(
                        true: fn(Builder $query) => $query->whereNotNull('depart'),
                        false: fn(Builder $query) => $query->whereNull('depart'),
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListEmployes::route('/'),
            'create' => Pages\CreateEmploye::route('/create'),
            'edit' => Pages\EditEmploye::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereNull('depart')->count();
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
