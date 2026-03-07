<?php

namespace App\Filament\Widgets;

use App\Models\Doctor;
use Filament\Widgets\ChartWidget;

class DoctorsAppointmentsChart extends ChartWidget
{
    protected ?string $heading = 'مقارنة حجوزات الأطباء';
protected static ?int $sort = 3;
    protected function getData(): array
    {
        $doctors = Doctor::withCount('appointments')->get();

        return [
            'datasets' => [
                [
                    'label' => 'عدد الحجوزات',
                    'data' => $doctors->pluck('appointments_count')->toArray(),
                ],
            ],
            'labels' => $doctors->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // ممكن تخليها line لو حابب
    }
}