<?php

namespace App\Filament\Doctor\Widgets;

use App\Models\Appointment;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class TodayAppointments extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // نجيب الدكتور اللي عامل login
        $doctorId = Auth::guard('doctor')->id();

        // نحسب عدد الحجوزات لليوم
        $todayAppointments = Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_date', today())
            ->count();

        return [
            Stat::make('حجوزات اليوم', $todayAppointments)
                ->description('عدد المواعيد اليوم')
                ->color('success'), // اللون الأخضر
        ];
    }
}