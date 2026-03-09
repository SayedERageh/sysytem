<?php

namespace App\Filament\Resources\Patients\RelationManagers;

use App\Models\InsuranceCompany;
use App\Models\InsurancePrice;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AppointmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'appointments';

    protected static ?string $title = 'الحجوزات';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Tabs::make('بيانات الحجز')
                    ->tabs([

                        Tab::make('الحجز')
                            ->schema([

                                Select::make('doctor_id')
                                    ->label('الدكتور')
                                    ->relationship('doctor', 'name')
                                    ->searchable()
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
                            ->schema([

                                Select::make('insurance_company_id')
                                    ->label('شركة التأمين')
                                    ->options(
                                        InsuranceCompany::pluck('name', 'id')->toArray()
                                    )
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set) {

                                        $services = InsurancePrice::where('insurance_company_id', $state)
                                            ->pluck('service_name', 'id')
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
                                    ->default(0)
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $get, callable $set) {

                                        $price = $get('service_price') ?? 0;
                                        $set('remaining', $price - $state);
                                    }),

                                TextInput::make('remaining')
                                    ->label('المتبقي')
                                    ->numeric()
                                    ->disabled(),

                            ])
                            ->columns(3),

                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('service_name')
            ->columns([

                TextColumn::make('doctor.name')
                    ->label('الدكتور')
                    ->searchable(),

                TextColumn::make('appointment_date')
                    ->label('التاريخ')
                    ->date(),

                TextColumn::make('appointment_time')
                    ->label('الوقت'),

                TextColumn::make('service_name')
                    ->label('الخدمة'),

                TextColumn::make('service_price')
                    ->label('السعر'),

                TextColumn::make('paid')
                    ->label('المدفوع'),

                TextColumn::make('remaining')
                    ->label('المتبقي'),

                TextColumn::make('status')
                    ->label('الحالة')
                    ->badge(),

            ])
            ->headerActions([
                CreateAction::make()->label('إضافة حجز'),
            ])
            ->recordActions([
                EditAction::make()->label('تعديل'),
                DeleteAction::make()->label('حذف'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}