<?php

namespace App\Filament\Resources\Appointments\Schemas;

use App\Models\InsuranceCompany;
use App\Models\InsurancePrice;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
      return $schema
    ->components([

        Tabs::make('بيانات الحجز')
            ->tabs([

                Tab::make('الحجز')
                    ->icon(Heroicon::CalendarDays)
                    ->schema([

                        Select::make('patient_id')
                            ->label('المريض')
                            ->relationship('patient', 'name')
                            ->searchable()
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

                    ])
                    ->columns(2),

                Tab::make('التأمين والخدمة')
                    ->icon(Heroicon::ShieldCheck)

                    ->schema([

                        Select::make('insurance_company_id')
                            ->label('شركة التأمين')
                            ->options(InsuranceCompany::pluck('name','id')->toArray())
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {

                                $services = InsurancePrice::where('insurance_company_id', $state)
                                    ->pluck('service_name','id')
                                    ->toArray();

                                $set('insurance_price_id', null);
                                $set('insurance_price_options', $services);
                            }),

                        Select::make('insurance_price_id')
                            ->label('الخدمة')
                            ->options(fn ($get) => $get('insurance_price_options') ?? [])
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $insurancePrice = InsurancePrice::find($state);
                                $set('service_name', $insurancePrice?->service_name ?? '');
                                $set('service_price', $insurancePrice?->service_price ?? 0);
                            }),

                        TextInput::make('service_name')
                            ->hidden(),

                        TextInput::make('service_price')
                            ->label('سعر الخدمة')
                            ->numeric()
                            ->disabled(),

                    ])
                    ->columns(2),

                Tab::make('الحالة والحسابات')
    ->icon(Heroicon::CurrencyDollar)
    ->schema([

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

        TextInput::make('approval_difference')
            ->label('فرق الموافقة')
            ->numeric()
            ->nullable(),

        Select::make('payment_method')
            ->label('طريقة الدفع')
            ->options([
                'cash' => 'كاش',
                'instapay' => 'إنستا باي',
            ])
            ->placeholder('اختر طريقة الدفع'),

    ])
    ->columns(3),

            ])
            ->persistTab() // يحفظ التاب المفتوح
            ->id('appointment-tabs'),

    ]);

            
    }
}
