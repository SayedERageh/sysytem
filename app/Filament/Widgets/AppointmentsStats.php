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
                'المدفوع اليوم خ',
                Appointment::whereDate('appointment_date', Carbon::today())
                    ->sum('paid')
            )
            ->color('success'),

            Stat::make(
                'إجمالي فرق الموافقة',
                Appointment::whereDate('appointment_date', Carbon::today())
                    ->sum('approval_difference')
            )
            ->color('warning'),

       Stat::make(
    'إجمالي دخل اليوم',
    Appointment::whereDate('appointment_date', Carbon::today())
        ->selectRaw('SUM(paid + IFNULL(approval_difference,0)) as total')
        ->value('total')
)
->color('success'),

        ];
    }
}