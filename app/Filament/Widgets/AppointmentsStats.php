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
                'إجمالي المدفوع اليوم',
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
                'إجمالي الكاش',
                Appointment::whereDate('appointment_date', Carbon::today())
                    ->where('payment_method', 'cash')
                    ->sum('paid')
            )
            ->color('primary'),

            Stat::make(
                'إجمالي الفيزا',
                Appointment::whereDate('appointment_date', Carbon::today())
                    ->where('payment_method', 'visa')
                    ->sum('paid')
            )
            ->color('info'),

        ];
    }
}