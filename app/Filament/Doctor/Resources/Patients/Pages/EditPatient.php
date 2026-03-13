<?php

namespace App\Filament\Doctor\Resources\Patients\Pages;

use App\Filament\Doctor\Resources\Patients\PatientResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPatient extends EditRecord
{
    protected static string $resource = PatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            
 // زر مخطط الأسنان مربوط بالروت
            Action::make('teeth_chart')
                ->label('مخطط الأسنان')
                ->color('secondary')
                ->icon('heroicon-o-sparkles') // أيقونة مناسبة
                ->url(fn () => route('teeth.index', ['patient' => $this->record->id])),
        ];
    }
}
