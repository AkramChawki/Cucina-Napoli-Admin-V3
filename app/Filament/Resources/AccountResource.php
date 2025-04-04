<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;


class AccountResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'RH';

    protected static ?string $modelLabel = 'Comptes';

    protected static ?string $slug = 'comptes';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label("Nom d utilisateur")
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->maxLength(255)
                    ->hiddenOn(Pages\EditAccount::class),
                    Forms\Components\Select::make('restau')
                    ->multiple()
                    ->label('Restaurant')
                    ->options([
                        'anoual' => 'Anoual',
                        'palmier' => 'Palmier',
                        'ziraoui' => 'Ziraoui',
                        'to go' => 'To Go'
                    ]),
                Forms\Components\Select::make('role')
                    ->multiple()
                    ->options(config("roles"))
                    ->required(),
                Forms\Components\Checkbox::make('guest')
                    ->label('Compte invité')
                    ->helperText('Cochez cette case si c\'est un compte invité')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label("Nom d utilisateur"),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('restau')
                    ->label('Restaurant')
                    ->formatStateUsing(fn ($state) => 
                        is_array($state) ? implode(', ', $state) : $state
                    ),
                Tables\Columns\TextColumn::make('role'),
                Tables\Columns\IconColumn::make('guest')
                    ->boolean()
                    ->label('Invité'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('email', 'LIKE', '%@cucinanapoli.com');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccounts::route('/'),
            'create' => Pages\CreateAccount::route('/create'),
            'edit' => Pages\EditAccount::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return true;
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
