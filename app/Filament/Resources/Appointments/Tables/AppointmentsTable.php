<?php

namespace App\Filament\Resources\Appointments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class AppointmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('patient.name')
                    ->label('المريض')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('doctor.name')
                    ->label('الدكتور')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('appointment_date')
                    ->label('التاريخ')
                    ->date(),

                TextColumn::make('appointment_time')
                    ->label('الوقت'),

                TextColumn::make('service_name')
                    ->label('الخدمة')
                    ->sortable(),

                TextColumn::make('service_price')
                    ->label('سعر الخدمة')
                    ->money('EGP'),

                BadgeColumn::make('status')
                    ->label('الحالة')
                    ->colors([
                        'primary' => 'في الانتظار',
                        'success' => 'تم الكشف',
                        'danger' => 'لم يأت',
                    ])
                    ->sortable(),

                TextColumn::make('insurance_company.name')
                    ->label('شركة التأمين'),

                TextColumn::make('paid')
                    ->label('المدفوع')
                    ->money('EGP'),

                TextColumn::make('remaining')
                    ->label('المتبقي')
                    ->money('EGP'),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
