<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Visit;
use App\Models\Patient;
use App\Models\Doctor;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Illuminate\Database\Eloquent\Model;

class CalendarWidget extends FullCalendarWidget
{
    protected static bool $isDiscovered = false;
    
    protected static ?string $heading = 'مواعيد العيادة';

    // ربط الكالندر بالموديل
    public Model|string|null $model = Visit::class;

  public function config(): array
{
    return [
        'initialView' => 'timeGridDay',
        'slotMinTime' => '08:00:00',
        'slotMaxTime' => '22:00:00',

        // السماح بالسحب
        'editable' => true,

        // السماح بتغيير مدة الموعد
        'eventDurationEditable' => true,
    ];
}

   public function fetchEvents(array $fetchInfo): array
{
    $start = Carbon::parse($fetchInfo['start']);
    $end = Carbon::parse($fetchInfo['end']);

    $doctorColors = [
        1 => '#3b82f6',
        2 => '#22c55e',
        3 => '#f59e0b',
        4 => '#ef4444',
    ];

    return Visit::with(['patient', 'doctor'])
        ->where('start', '>=', $start)
        ->where('end', '<=', $end)
        ->get()
        ->map(function (Visit $visit) use ($doctorColors) {

            $color = $doctorColors[$visit->doctor_id] ?? '#6366f1';

            return [
                'id' => $visit->id,
                'title' => $visit->doctor->name . ' - ' . $visit->patient->name,
                'start' => $visit->start,
                'end' => $visit->end,
                'allDay' => false,
                'backgroundColor' => $color,
                'borderColor' => $color,
            ];
        })
        ->toArray();
}
protected function getDefaultEventData(): array
{
    $start = $this->mountedActionArguments['start'] ?? now();

    $startDate = Carbon::parse($start);
    $endDate = $startDate->copy()->addHour();

    return [
        'start' => $startDate,
        'end' => $endDate,
    ];
}
 public function getFormSchema(): array
{
    return [

        TextInput::make('name')
            ->label('نوع الزيارة')
            ->required(),

        Select::make('patient_id')
            ->label('المريض')
            ->options(Patient::pluck('name', 'id'))
            ->searchable()
            ->required(),

        Select::make('doctor_id')
            ->label('الدكتور')
            ->options(Doctor::pluck('name', 'id'))
            ->searchable()
            ->required(),

        DateTimePicker::make('start')
            ->label('بداية الموعد')
            ->required(),

        DateTimePicker::make('end')
            ->label('نهاية الموعد')
            ->required(),

        Toggle::make('allDay')
            ->label('كل اليوم')
            ->default(false)
            ->hidden(),

    ];
}

}