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
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Filament\Notifications\Notification;

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
                        // Limit the number of records to export for better performance
                        if ($records->count() > 10000) {
                            Notification::make()
                                ->title('Trop de données')
                                ->body('Veuillez réduire le nombre d\'enregistrements à exporter (maximum 10000)')
                                ->danger()
                                ->send();
                            return;
                        }
                        
                        return response()->streamDownload(function () use ($records) {
                            // Create a new Excel file with minimal memory usage
                            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
                            $sheet = $spreadsheet->getActiveSheet();
                            $sheet->setTitle('Cloture de Caisse');
                            
                            // Disable auto-calculation for better performance
                            $spreadsheet->getCalculationEngine()->disableCalculationCache();
                            
                            // Define headers
                            $headers = [
                                'A1' => 'Nom',
                                'B1' => 'Restaurant',
                                'C1' => 'Date',
                                'D1' => 'Heure',
                                'E1' => 'Responsable',
                                'F1' => 'Montant Total',
                                'G1' => 'Montant Espèce',
                                'H1' => 'Carte Bancaire',
                                'I1' => 'CB Livraison',
                                'J1' => 'Virement',
                                'K1' => 'Chèque',
                                'L1' => 'Compensation',
                                'M1' => 'Famille & Accompagnant',
                                'N1' => 'Erreur Pizza',
                                'O1' => 'Erreur Cuisine',
                                'P1' => 'Erreur Serveur',
                                'Q1' => 'Erreur Caisse',
                                'R1' => 'Perte Emporte',
                                'S1' => 'Giveaway Pizza',
                                'T1' => 'Giveaway Pasta',
                                'U1' => 'Glovo Espèce',
                                'V1' => 'Glovo Carte',
                                'W1' => 'App Espèce',
                                'X1' => 'App Carte',
                                'Y1' => 'Shooting',
                                'Z1' => 'Commission Glovo',
                            ];
                            
                            // Add headers directly
                            foreach ($headers as $cell => $value) {
                                $sheet->setCellValue($cell, $value);
                            }
                            
                            // Add data rows - use direct cell references for speed
                            $rowIndex = 2;
                            foreach ($records as $record) {
                                // Use a more efficient approach to check date fields
                                $dateFormatted = '';
                                if (!empty($record->date)) {
                                    if ($record->date instanceof \DateTime) {
                                        $dateFormatted = $record->date->format('d/m/Y');
                                    } else if (is_string($record->date)) {
                                        try {
                                            $dateObj = new \DateTime($record->date);
                                            $dateFormatted = $dateObj->format('d/m/Y');
                                        } catch (\Exception $e) {
                                            $dateFormatted = $record->date;
                                        }
                                    }
                                }
                                
                                $timeFormatted = '';
                                if (!empty($record->time)) {
                                    if ($record->time instanceof \DateTime) {
                                        $timeFormatted = $record->time->format('H:i');
                                    } else if (is_string($record->time)) {
                                        try {
                                            $timeObj = new \DateTime($record->time);
                                            $timeFormatted = $timeObj->format('H:i');
                                        } catch (\Exception $e) {
                                            $timeFormatted = $record->time;
                                        }
                                    }
                                }
                                
                                // Set cell values directly for better performance
                                $sheet->setCellValue('A' . $rowIndex, $record->name ?? '');
                                $sheet->setCellValue('B' . $rowIndex, $record->restau ?? '');
                                $sheet->setCellValue('C' . $rowIndex, $dateFormatted);
                                $sheet->setCellValue('D' . $rowIndex, $timeFormatted);
                                $sheet->setCellValue('E' . $rowIndex, $record->responsable ?? '');
                                $sheet->setCellValue('F' . $rowIndex, $record->montant ?? 0);
                                $sheet->setCellValue('G' . $rowIndex, $record->montantE ?? 0);
                                $sheet->setCellValue('H' . $rowIndex, $record->cartebancaire ?? 0);
                                $sheet->setCellValue('I' . $rowIndex, $record->cartebancaireLivraison ?? 0);
                                $sheet->setCellValue('J' . $rowIndex, $record->virement ?? 0);
                                $sheet->setCellValue('K' . $rowIndex, $record->cheque ?? 0);
                                $sheet->setCellValue('L' . $rowIndex, $record->compensation ?? 0);
                                $sheet->setCellValue('M' . $rowIndex, $record->familleAcc ?? 0);
                                $sheet->setCellValue('N' . $rowIndex, $record->erreurPizza ?? 0);
                                $sheet->setCellValue('O' . $rowIndex, $record->erreurCuisine ?? 0);
                                $sheet->setCellValue('P' . $rowIndex, $record->erreurServeur ?? 0);
                                $sheet->setCellValue('Q' . $rowIndex, $record->erreurCaisse ?? 0);
                                $sheet->setCellValue('R' . $rowIndex, $record->perteEmporte ?? 0);
                                $sheet->setCellValue('S' . $rowIndex, $record->giveawayPizza ?? 0);
                                $sheet->setCellValue('T' . $rowIndex, $record->giveawayPasta ?? 0);
                                $sheet->setCellValue('U' . $rowIndex, $record->glovoE ?? 0);
                                $sheet->setCellValue('V' . $rowIndex, $record->glovoC ?? 0);
                                $sheet->setCellValue('W' . $rowIndex, $record->appE ?? 0);
                                $sheet->setCellValue('X' . $rowIndex, $record->appC ?? 0);
                                $sheet->setCellValue('Y' . $rowIndex, $record->shooting ?? 0);
                                $sheet->setCellValue('Z' . $rowIndex, $record->ComGlovo ?? 0);
                                
                                $rowIndex++;
                                
                                // Flush memory periodically for large exports
                                if ($rowIndex % 100 === 0) {
                                    \PhpOffice\PhpSpreadsheet\Calculation\Calculation::getInstance()->flushInstance();
                                    gc_collect_cycles();
                                }
                            }
                            
                            // Format the header row
                            $sheet->getStyle('A1:Z1')->getFont()->setBold(true);
                            $sheet->getStyle('A1:Z1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('DDDDDD');
                            
                            // Format currency cells
                            $currencyFormat = '#,##0.00 [$MAD]';
                            $sheet->getStyle('F2:Z' . ($rowIndex - 1))->getNumberFormat()->setFormatCode($currencyFormat);
                            
                            // Auto-size columns but with a smarter approach
                            // Only auto-size for smaller datasets to improve performance
                            if ($records->count() < 1000) {
                                foreach (range('A', 'Z') as $column) {
                                    $sheet->getColumnDimension($column)->setAutoSize(true);
                                }
                            } else {
                                // Set reasonable static widths for larger datasets
                                foreach (range('A', 'Z') as $column) {
                                    $sheet->getColumnDimension($column)->setWidth(15);
                                }
                            }
                            
                            // Use a memory-efficient writer
                            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
                            $writer->setPreCalculateFormulas(false);
                            $writer->save('php://output');
                            
                            // Clean up
                            $spreadsheet->disconnectWorksheets();
                            unset($spreadsheet);
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