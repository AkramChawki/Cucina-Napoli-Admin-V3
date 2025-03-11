<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClotureCaisseResource\Pages;
use App\Models\ClotureCaisse;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ClotureCaisseResource extends Resource
{
    protected static ?string $model = ClotureCaisse::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Chiffre Affaire';

    protected static ?string $navigationLabel = 'Cloture de Caisse';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nom')
                                    ->required(),
                                TextInput::make('restau')
                                    ->label('Restaurant')
                                    ->required(),
                                DatePicker::make('date')
                                    ->required(),
                                TimePicker::make('time')
                                    ->required(),
                                TextInput::make('responsable')
                                    ->required(),
                                TextInput::make('montant')
                                    ->label('Montant Total')
                                    ->numeric()
                                    ->required(),
                                TextInput::make('montantE')
                                    ->label('Montant Espèce')
                                    ->numeric(),
                                TextInput::make('cartebancaire')
                                    ->label('Carte Bancaire')
                                    ->numeric(),
                                TextInput::make('cartebancaireLivraison')
                                    ->label('CB Livraison')
                                    ->numeric(),
                                TextInput::make('virement')
                                    ->numeric(),
                                TextInput::make('cheque')
                                    ->numeric(),
                                TextInput::make('compensation')
                                    ->numeric(),
                                TextInput::make('familleAcc')
                                    ->label('Famille & Accompagnant')
                                    ->numeric(),
                                TextInput::make('erreurPizza')
                                    ->label('Erreur Pizza')
                                    ->numeric(),
                                TextInput::make('erreurCuisine')
                                    ->label('Erreur Cuisine')
                                    ->numeric(),
                                TextInput::make('erreurServeur')
                                    ->label('Erreur Serveur')
                                    ->numeric(),
                                TextInput::make('erreurCaisse')
                                    ->label('Erreur Caisse')
                                    ->numeric(),
                                TextInput::make('perteEmporte')
                                    ->label('Perte Emporte')
                                    ->numeric(),
                                TextInput::make('giveawayPizza')
                                    ->numeric(),
                                TextInput::make('giveawayPasta')
                                    ->numeric(),
                                TextInput::make('glovoE')
                                    ->label('Glovo Espèce')
                                    ->numeric(),
                                TextInput::make('glovoC')
                                    ->label('Glovo Carte')
                                    ->numeric(),
                                TextInput::make('appE')
                                    ->label('App Espèce')
                                    ->numeric(),
                                TextInput::make('appC')
                                    ->label('App Carte')
                                    ->numeric(),
                                TextInput::make('shooting')
                                    ->numeric(),
                                TextInput::make('ComGlovo')
                                    ->label('Commission Glovo')
                                    ->numeric()
                                    ->disabled(),
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('restau')
                    ->label('Restaurant')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('date')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('responsable')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('montant')
                    ->label('Montant Caisse')
                    ->money('mad')
                    ->sortable()
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->money('mad'),
                    ]),

                Tables\Columns\TextColumn::make('montantE')
                    ->label('Espèces')
                    ->money('mad')
                    ->sortable()
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->money('mad'),
                    ]),

                Tables\Columns\TextColumn::make('cartebancaire')
                    ->label('Carte Bancaire')
                    ->money('mad')
                    ->sortable()
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->money('mad'),
                    ]),

                Tables\Columns\TextColumn::make('ComGlovo')
                    ->label('Com. Glovo')
                    ->money('mad')
                    ->color('danger')
                    ->sortable()
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->money('mad'),
                    ]),
            ])
            ->defaultSort('date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('restau')
                    ->label('Restaurant')
                    ->options(fn() => ClotureCaisse::distinct()->pluck('restau', 'restau')->toArray())
                    ->multiple(),

                Tables\Filters\Filter::make('date')
                    ->form([
                        DatePicker::make('date_from')
                            ->label('Du'),
                        DatePicker::make('date_to')
                            ->label('Au'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['date_from'],
                                fn($query) => $query->whereDate('date', '>=', $data['date_from'])
                            )
                            ->when(
                                $data['date_to'],
                                fn($query) => $query->whereDate('date', '<=', $data['date_to'])
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->requiresConfirmation(),
                Tables\Actions\BulkAction::make('export')
                    ->label('Exporter vers Excel')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(function ($records) {
                        return response()->streamDownload(function () use ($records) {
                            // Create a new Excel file
                            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                            $sheet = $spreadsheet->getActiveSheet();
                            
                            // Set headers
                            $headers = [
                                'Nom', 'Restaurant', 'Date', 'Heure', 'Responsable', 
                                'Montant Total', 'Montant Espèce', 'Carte Bancaire', 'CB Livraison',
                                'Virement', 'Chèque', 'Compensation', 'Famille & Accompagnant',
                                'Erreur Pizza', 'Erreur Cuisine', 'Erreur Serveur', 'Erreur Caisse',
                                'Perte Emporte', 'Giveaway Pizza', 'Giveaway Pasta', 
                                'Glovo Espèce', 'Glovo Carte', 'App Espèce', 'App Carte',
                                'Shooting', 'Commission Glovo'
                            ];
                            
                            // Add headers
                            foreach ($headers as $columnIndex => $header) {
                                $sheet->setCellValueByColumnAndRow($columnIndex + 1, 1, $header);
                            }
                            
                            // Add data rows
                            $rowIndex = 2;
                            foreach ($records as $record) {
                                $columnIndex = 1;
                                
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->name);
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->restau);
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->date ? $record->date->format('d/m/Y') : '');
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->time ? $record->time->format('H:i') : '');
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->responsable);
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->montant);
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->montantE);
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->cartebancaire);
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->cartebancaireLivraison);
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->virement);
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->cheque);
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->compensation);
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->familleAcc);
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->erreurPizza);
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->erreurCuisine);
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->erreurServeur);
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->erreurCaisse);
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->perteEmporte);
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->giveawayPizza);
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->giveawayPasta);
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->glovoE);
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->glovoC);
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->appE);
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->appC);
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->shooting);
                                $sheet->setCellValueByColumnAndRow($columnIndex++, $rowIndex, $record->ComGlovo);
                                
                                $rowIndex++;
                            }
                            
                            // Format the cells
                            $sheet->getStyle('A1:Z1')->getFont()->setBold(true);
                            
                            // Auto-size columns
                            foreach (range('A', 'Z') as $column) {
                                $sheet->getColumnDimension($column)->setAutoSize(true);
                            }
                            
                            // Output the file
                            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                            $writer->save('php://output');
                        }, 'cloture-caisse-' . now()->format('Y-m-d') . '.xlsx', [
                            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        ]);
                    })
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClotureCaisses::route('/'),
            'create' => Pages\CreateClotureCaisse::route('/create'),
            'edit' => Pages\EditClotureCaisse::route('/{record}/edit'),
            'view' => Pages\ViewClotureCaisse::route('/{record}'),
        ];
    }
    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        return $user && (
            $user->email == "admin@cucinanapoli.com" ||
            $user->email == "nimane@cucinanapoli.com" ||
            $user->email == "bfati@cucinanapoli.com"

        );
    }
}