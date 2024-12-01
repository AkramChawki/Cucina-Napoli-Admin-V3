<?php

namespace App\Filament\Resources\PresenceResource\Pages;

use App\Filament\Resources\PresenceResource;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;

class ViewAttendance extends Page
{
    use InteractsWithRecord;

    protected static string $resource = PresenceResource::class;

    protected static string $view = 'filament.pages.presence-attendance';

    public $record;

    public function mount($record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    protected function getViewData(): array
    {
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $this->record->month, $this->record->year);
        
        $statusColors = [
            'present' => '#22c55e',
            'absent' => '#ef4444',
            'conge-paye' => '#3b82f6',
            'conge-non-paye' => '#f97316',
            'repos' => '#6b7280',
            'continue' => '#eab308',
        ];

        $statusLabels = [
            'present' => 'P',
            'absent' => 'A',
            'conge-paye' => 'CP',
            'conge-non-paye' => 'CNP',
            'repos' => 'R',
            'continue' => 'CC',
        ];

        return [
            'presence' => $this->record,
            'daysInMonth' => $daysInMonth,
            'statusColors' => $statusColors,
            'statusLabels' => $statusLabels,
        ];
    }
}