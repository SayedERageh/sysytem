<?php

namespace App\Filament\Doctor\Resources\Patients\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
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
                Select::make('doctor_id')
                    ->relationship('doctor', 'name')
                    ->label('الدكتور')
                    ->required(),

                DatePicker::make('appointment_date')
                    ->label('تاريخ الحجز')
                    ->required(),

                TimePicker::make('appointment_time')
                    ->label('وقت الحجز')
                    ->required(),

                TextInput::make('service_name')
                    ->label('الخدمة')
                    ->required(),

                TextInput::make('service_price')
                    ->label('سعر الخدمة')
                    ->numeric()
                    ->required(),

                Select::make('status')
                    ->label('الحالة')
                    ->options([
                        'لم ياتي'      => 'لم ياتي',
                        'في الانتظار'  => 'في الانتظار',
                        'تم الكشف'     => 'تم الكشف',
                    ])
                    ->default('في الانتظار')
                    ->required(),

                Select::make('insurance_company_id')
                    ->relationship('company', 'name')
                    ->label('شركة التأمين')
                    ->nullable(),

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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('service_name')
            ->columns([
                TextColumn::make('doctor.name')->label('الدكتور')->searchable(),
                TextColumn::make('appointment_date')->label('تاريخ الحجز')->date(),
                TextColumn::make('appointment_time')->label('وقت الحجز'),
                TextColumn::make('service_name')->label('الخدمة')->searchable(),
                TextColumn::make('service_price')->label('سعر الخدمة'),
                TextColumn::make('status')->label('الحالة'),
                TextColumn::make('insurance_company.name')->label('شركة التأمين'),
                TextColumn::make('paid')->label('المدفوع'),
                TextColumn::make('remaining')->label('المتبقي'),
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