<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class AppointmentsStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
 Stat::make(
                'إجمالي الكاش',
                Appointment::whereDate('appointment_date', Carbon::today())
                    ->where('payment_method', 'cash')
                    ->selectRaw('SUM(paid + approval_difference) as total')
                    ->value('total')
            )
            ->color('primary'),

            Stat::make(
                'إجمالي الفيزا',
                Appointment::whereDate('appointment_date', Carbon::today())
                    ->where('payment_method', 'visa')
                    ->selectRaw('SUM(paid + approval_difference) as total')
                    ->value('total')
            )
            ->color('info'),

        ];
    }
}