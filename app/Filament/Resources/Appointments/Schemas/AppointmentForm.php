<?php

namespace App\Filament\Resources\Appointments\Schemas;

use App\Models\InsuranceCompany;
use App\Models\InsurancePrice;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('patient_id')
                    ->label('المريض')
                    ->relationship('patient', 'name')
                    ->required(),

                Select::make('doctor_id')
                    ->label('الدكتور')
                    ->relationship('doctor', 'name')
                    ->required(),

                DatePicker::make('appointment_date')
                    ->label('التاريخ')
                    ->required(),

                TimePicker::make('appointment_time')
                    ->label('الوقت')
                    ->required(),

                // اختيار شركة التأمين
                Select::make('insurance_company_id')
                    ->label('شركة التأمين')
                    ->options(InsuranceCompany::pluck('name','id')->toArray())
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        // تحديث قائمة الخدمات حسب الشركة
                        $services = InsurancePrice::where('insurance_company_id', $state)
                            ->pluck('service_name','id')
                            ->toArray();

                        $set('insurance_price_id_options', $services);
                        $set('insurance_price_id', null); // مسح الخدمة المختارة
                    }),

                // اختيار الخدمة حسب الشركة
                Select::make('insurance_price_id')
                    ->label('الخدمة')
                    ->options(fn ($get) => $get('insurance_price_id_options') ?? [])
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $insurancePrice = InsurancePrice::find($state);
                        $set('service_name', $insurancePrice?->service_name ?? '');
                        $set('service_price', $insurancePrice?->service_price ?? 0);
                    }),

                TextInput::make('service_name')
                    ->label('اسم الخدمة')
                ->hidden(),

                TextInput::make('service_price')
                    ->label('سعر الخدمة')
                    ->numeric()
                    ->disabled(),

                Select::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending' => 'في الانتظار',
                        'done' => 'تم الكشف',
                        'absent' => 'لم يأت',
                    ])
                    ->default('pending'),

                TextInput::make('paid')
                    ->label('المدفوع')
                    ->numeric()
                    ->default(0),

                TextInput::make('remaining')
                    ->label('المتبقي')
                    ->numeric()
                    ->default(0),
            ]);
            
    }
}
