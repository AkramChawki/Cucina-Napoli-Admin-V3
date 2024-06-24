<?php

namespace App\Filament\Widgets;

use App\Models\Reservation;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

use Filament\Widgets\ChartWidget;

class ReservationChart extends ChartWidget
{
    protected static ?string $heading = 'Reservations';
    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $data = Trend::model(Reservation::class)
            ->between(
                start: now()->startOfWeek(),
                end: now()->endOfWeek(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Reservations Recu',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
