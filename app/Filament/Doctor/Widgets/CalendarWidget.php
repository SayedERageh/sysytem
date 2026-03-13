<?php

namespace App\Filament\Doctor\Widgets;

use App\Models\Appointment;
use Carbon\Carbon;
use App\Models\Patient;
use App\Models\InsuranceCompany;
use Filament\Facades\Filament;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Illuminate\Database\Eloquent\Model;

class CalendarWidget extends FullCalendarWidget
{
    protected static bool $isDiscovered = false;

    protected static ?string $heading = 'مواعيدي';

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
        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        $start = Carbon::parse($fetchInfo['start']);
        $end = Carbon::parse($fetchInfo['end']);

        $doctorId = Filament::auth()->id();

        return Appointment::with(['doctor', 'company'])
            ->where('doctor_id', $doctorId)
            ->whereBetween('appointment_date', [$start, $end])
            ->get()
            ->map(function (Appointment $appointment) {

                return [
                    'id' => $appointment->id,
                    'title' => $appointment->doctor->name . ' - ' . ($appointment->company->name ?? 'بدون تأمين'),
                    'start' => $appointment->appointment_date,
                    'backgroundColor' => '#3b82f6',
                    'borderColor' => '#3b82f6',
                ];
            })
            ->toArray();
    }

   
}