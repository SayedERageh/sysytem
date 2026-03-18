<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Expense;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class AppointmentsStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [

            Stat::make(
                'المدفوع اليوم الخاص',
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
    // ✅ الجديد هنا
            Stat::make(
                'إجمالي المصروفات اليوم',
                Expense::whereDate('created_at', Carbon::today())
                    ->sum('price')
            )
            ->color('danger'),


        ];
    }
}