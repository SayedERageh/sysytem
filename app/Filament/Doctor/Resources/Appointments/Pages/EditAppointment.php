<?php

namespace App\Filament\Doctor\Resources\Appointments\Pages;

use App\Models\TeethProcedure;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Doctor\Resources\Appointments\AppointmentResource;

class EditAppointment extends EditRecord
{
    protected static string $resource = AppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $data = $this->form->getState();

        TeethProcedure::create([
            'patient_id'      => $this->record->patient_id,
            'tooth_number'    => $data['teeth_number'] ?? null,
            'procedure'       => $data['diagnosis_chart'] ?? null,
            'notes'           => $data['notes'] ?? null,
            'next_procedure'  => $data['next_session'] ?? null,
            'next_notes'      => $data['notes'] ?? null,
            'w_l'             => $data['teeth_length'] ?? null,
        ]);
    }
}
