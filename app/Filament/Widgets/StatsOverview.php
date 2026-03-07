<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\LabRequest;
use App\Models\Radiology;
use Carbon\Carbon;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [

            // حجوزات اليوم
            Stat::make(
                'حجوزات اليوم',
                Appointment::whereDate('appointment_date', Carbon::today())->count()
            )
                ->description('عدد الحجوزات اليوم')
                ->color('primary'),

            // إجمالي المرضى
            Stat::make(
                'إجمالي المرضى',
                Patient::count()
            )
                ->description('عدد المرضى المسجلين')
                ->color('success'),

            // إجمالي الدكاترة
            Stat::make(
                'إجمالي الدكاترة',
                Doctor::count()
            )
                ->description('عدد الأطباء')
                ->color('info'),

            // طلبات المعامل الشهرية
            Stat::make(
                'تحاليل هذا الشهر',
                LabRequest::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count()
            )
                ->description('عدد طلبات المعامل الشهرية')
                ->color('warning'),

            // الأشعة الشهرية
            Stat::make(
                'أشعة هذا الشهر',
                Radiology::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count()
            )
                ->description('عدد طلبات الأشعة الشهرية')
                ->color('danger'),

        ];
    }
}