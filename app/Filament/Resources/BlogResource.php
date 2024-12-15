<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Models\Blog;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Site';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label("Titre")
                    ->required()
                    ->lazy()
                    ->afterStateUpdated(fn (string $context, $state, callable $set) => $context === 'create' ? $set('slug', Str::slug($state)) : null),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(Blog::class, 'slug', ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('sujet')
                    ->columnSpan("full")
                    ->required(),
                Forms\Components\RichEditor::make('resume')
                    ->columnSpan("full")
                    ->required(),
                Forms\Components\RichEditor::make('Primary')
                    ->label("Premier Text")
                    ->columnSpan("full")
                    ->required(),
                Forms\Components\RichEditor::make('Secondary')
                    ->label("Deuxieme Text")
                    ->columnSpan("full")
                    ->required(),
                Forms\Components\FileUpload::make('imageP')
                    ->label("Image Principale")
                    ->image()
                    ->directory("blog")
                    ->required(),
                Forms\Components\FileUpload::make('image1')
                    ->label("Image 1")
                    ->image()
                    ->directory("blog")
                    ->required(),
                Forms\Components\FileUpload::make('image2')
                    ->label("Image 2")
                    ->image()
                    ->directory("blog")
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('imageP')->square()->label("Image"),
                Tables\Columns\TextColumn::make('title')
                    ->label("Titre")
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->after(function (Blog $record) {
                        $filesToDelete = array_filter([$record->imageP, $record->image1, $record->image2]);
                        if (!empty($filesToDelete)) {
                            Storage::disk('public')->delete($filesToDelete);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->after(function (Collection $records) {
                        $filesToDelete = $records->flatMap(function ($record) {
                            return array_filter([$record->imageP, $record->image1, $record->image2]);
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && (
            $user->email == "admin@cucinanapoli.com" ||
            $user->email == "nimane@cucinanapoli.com" ||
            $user->email == "nyoussef@cucinanapoli.com" ||
            $user->email == "basmaa@cucinanapoli.com"
        );
    }
}
