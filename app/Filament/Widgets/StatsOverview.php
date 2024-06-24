<?php

namespace App\Filament\Widgets;

use App\Models\CuisinierOrder;
use App\Models\Order;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $today = Carbon::today();
        $Year = Carbon::now()->year;
        return [
            Stat::make("Commande d'auhourd'hui", Order::whereDate('created_at', $today)->count())
                ->description("Utilisteurs qui ont créer un compte aujourd'hui"),
            Stat::make("Total des commande", Order::whereDate('created_at', $today)->sum('total') . " DH")
                ->description("Total des prix de commande du jour"),
            Stat::make("Reservations d'auhourd'hui", Reservation::whereDate('created_at', $today)->count())
                ->description("Utilisteurs qui ont créer un compte aujourd'hui"),
            Stat::make("Nouveaux utilisteurs", User::whereDate('created_at', $today)->count())
                ->description("Utilisteurs qui ont créer un compte aujourd'hui"),
            Stat::make("Commande Cuisinier d'aujourd'hui", CuisinierOrder::whereDate('created_at', $today)->count())
                ->description("Commande Cuisinier Recu aujourd'hui"),
        ];
    }
}
