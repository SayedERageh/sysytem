<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\InsuranceCompany;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Illuminate\Database\Eloquent\Model;

class CalendarWidget extends FullCalendarWidget
{
    protected static ?string $heading = 'مواعيد العيادة';
    protected static bool $isDiscovered = false;


    public Model|string|null $model = Appointment::class;

    public function config(): array
    {
        return [
            'initialView' => 'timeGridDay',

            'slotMinTime' => '10:00:00',

            'slotMaxTime' => '24:00:00',

            'slotDuration' => '00:30:00',

            'defaultTimedEventDuration' => '00:30:00',

            'editable' => true,

            'nowIndicator' => true,
        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        $doctorColors = [
      1 => '#3b82f6',
2 => '#22c55e',
3 => '#f59e0b',
4 => '#ef4444',
5 => '#8b5cf6',
6 => '#06b6d4',
7 => '#84cc16',
8 => '#f97316',
        ];

        return Appointment::with(['patient','doctor'])
            ->whereBetween('appointment_date', [
                $fetchInfo['start'],
                $fetchInfo['end']
            ])
            ->get()
            ->map(function (Appointment $appointment) use ($doctorColors) {

              $start = Carbon::parse($appointment->appointment_date)
            ->setTimeFromTimeString($appointment->appointment_time);

                $end = $start->copy()->addMinutes(30);

                $color = $doctorColors[$appointment->doctor_id] ?? '#6366f1';

                return [
                    'id' => $appointment->id,
                    'title' => $appointment->patient->name . ' - ' . $appointment->doctor->name,
                    'start' => $start->toIso8601String(),
                    'end' => $end->toIso8601String(),
                    'backgroundColor' => $color,
                    'borderColor' => $color,
                ];
            })
            ->toArray();
    }

    public function getFormSchema(): array
    {
        return [

            Select::make('patient_id')
                ->label('المريض')
                ->relationship('patient','name')
                ->searchable()
                ->required(),

            Select::make('doctor_id')
                ->label('الدكتور')
                ->relationship('doctor','name')
             
                ->required(),

            Select::make('insurance_company_id')
                ->label('شركة التأمين')
                ->options(InsuranceCompany::pluck('name','id'))
                ->searchable()

                ->required(),

      

        

            DatePicker::make('appointment_date')
                ->label('التاريخ')
                ->required(),

            TimePicker::make('appointment_time')
                ->label('الوقت')
                ->seconds(false)
                ->required(),
        ];
    }
}