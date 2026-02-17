<?php

namespace App\Filament\Resources\Appointments\Pages;

use App\Filament\Resources\Appointments\AppointmentResource;
use App\Models\InsurancePrice;
use Filament\Resources\Pages\CreateRecord;

class CreateAppointment extends CreateRecord
{
    protected static string $resource = AppointmentResource::class;

    // هانعمل هنا قبل الحفظ
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // لو المستخدم اختار خدمة من التأمين
        if (isset($data['insurance_price_id'])) {
            $insurancePrice = InsurancePrice::find($data['insurance_price_id']);
            $data['service_name'] = $insurancePrice?->service_name ?? '';
            $data['service_price'] = $insurancePrice?->service_price ?? 0;
        }

        return $data;
    }
}
