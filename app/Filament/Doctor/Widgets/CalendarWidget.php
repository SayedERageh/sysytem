<?php

namespace App\Filament\Doctor\Widgets;

use App\Models\Appointment;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Illuminate\Database\Eloquent\Builder;
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
            'editable' => false,
            'nowIndicator' => true,
        ];
    }

    /**
     * فلترة المواعيد للدكتور الحالي
     */
    protected function getEloquentQuery(): Builder
    {
        return Appointment::query()
            ->where('doctor_id', Filament::auth()->id());
    }

    /**
     * تجهيز البيانات للكاليـندر
     */
    public function fetchEvents(array $fetchInfo): array
    {
        $start = Carbon::parse($fetchInfo['start']);
        $end = Carbon::parse($fetchInfo['end']);

        return $this->getEloquentQuery()
            ->with(['patient','company'])
            ->whereBetween('appointment_date', [$start, $end])
            ->get()
            ->map(function (Appointment $appointment) {

                $startDate = Carbon::parse($appointment->appointment_date)
                    ->setTimeFromTimeString($appointment->appointment_time);

                $endDate = $startDate->copy()->addMinutes(30);

                return [
                    'id' => $appointment->id,

                    'title' =>
                        ($appointment->patient->name ?? 'مريض')
                        .' - '.
                        ($appointment->company->name ?? 'بدون تأمين'),

                    'start' => $startDate->toIso8601String(),
                    'end' => $endDate->toIso8601String(),

                    'backgroundColor' => '#3b82f6',
                    'borderColor' => '#3b82f6',
                ];
            })
            ->toArray();
    }

    /**
     * الفورم (الدكتور لا ينشئ موعد)
     */
    public function getFormSchema(): array
    {
        return [];
    }
}