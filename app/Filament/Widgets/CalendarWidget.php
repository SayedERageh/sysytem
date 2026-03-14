<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Carbon\Carbon;
use App\Models\Visit;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\InsuranceCompany;
use App\Models\InsurancePrice;
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
public Model|string|null $model = Appointment::class;
public function config(): array
{
    return [
        'initialView' => 'timeGridDay',

        // يبدأ من 10 صباحا
        'slotMinTime' => '10:00:00',

        // ينتهي 12 مساء (منتصف الليل)
        'slotMaxTime' => '24:00:00',

        'slotDuration' => '00:30:00',
        'defaultTimedEventDuration' => '00:30:00',

        'editable' => true,
    ];
}
public function fetchEvents(array $fetchInfo): array
{
    $doctorColors = [
        1 => '#3b82f6',
        2 => '#22c55e',
        3 => '#f59e0b',
        4 => '#ef4444',
    ];

    return Appointment::with(['doctor', 'company'])
        ->whereBetween('appointment_date', [
            $fetchInfo['start'],
            $fetchInfo['end']
        ])
        ->get()
        ->map(function (Appointment $appointment) use ($doctorColors) {

            $start = $appointment->appointment_date;
            $end = $appointment->appointment_date->copy()->addMinutes(30);

            $color = $doctorColors[$appointment->doctor_id] ?? '#6366f1';

            return [
                'id' => $appointment->id,
                'title' => $appointment->patient->name . ' - ' . $appointment->doctor->name,
                'start' => $start,
                'end' => $end,
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
            ->options(Patient::pluck('name', 'id'))
            ->searchable()
            ->required(),

        Select::make('doctor_id')
            ->label('الدكتور')
            ->options(Doctor::pluck('name', 'id'))
            ->searchable()
            ->required(),

       Select::make('insurance_company_id')
                            ->label('شركة التأمين')
                            ->options(InsuranceCompany::pluck('name','id')->toArray())
                            ->required()
                           ,

                        TextInput::make('service_name')
                        ->default('كشف عادي او متابعه')
                            ->hidden(),

                        TextInput::make('service_price')
                            ->label('سعر الخدمة')
                            ->numeric()
                            ->default(0)
                           ->hidden(),
                    

DateTimePicker::make('appointment_date')
    ->label('موعد الحجز')
    ->required()
    ->default(fn () => Carbon::now()) // التاريخ والوقت الحالي

    ];
}

}