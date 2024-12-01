<?php

namespace App\Filament\Resources\PresenceResource\Pages;

use App\Filament\Resources\PresenceResource;
use Filament\Resources\Pages\Page;

class ViewAttendance extends Page
{
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
            'present' => 'rgb(34 197 94)', // green-500
            'absent' => 'rgb(239 68 68)', // red-500
            'conge-paye' => 'rgb(59 130 246)', // blue-500
            'conge-non-paye' => 'rgb(249 115 22)', // orange-500
            'repos' => 'rgb(107 114 128)', // gray-500
            'continue' => 'rgb(234 179 8)', // yellow-500
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

    protected function getHeaderActions(): array
    {
        return [];
    }
}