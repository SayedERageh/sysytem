<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Doctor;

class DoctorsWorkingHours extends StatsOverviewWidget
{

    protected static bool $isDiscovered = false;

protected function getStats(): array
    {
        $stats = [];

        $doctors = Doctor::orderBy('name')->get();

        foreach ($doctors as $doctor) {

        $workingHours = is_array($doctor->working_hours)
            ? collect($doctor->working_hours)
                ->map(fn($time, $day) => "$day: $time")
                ->implode(' | ')
            : $doctor->working_hours;

        
        $stats[] = Stat::make(
            '', // ❌ مفيش title
            $doctor->name // ✅ ده الكبير
        )
                ->description($workingHours ?: 'لا يوجد مواعيد') // 👈 ده الصغير
                ->descriptionIcon('heroicon-o-clock') // ⏰ أيقونة
                ->color('success') // 🎨 اللون
                ->extraAttributes([
                    'class' => 'text-lg font-bold', // تكبير الاسم
                ]);
        }

        return $stats;
    }
}