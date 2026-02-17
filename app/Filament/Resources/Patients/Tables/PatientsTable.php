<?php

namespace App\Filament\Resources\Patients\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class PatientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label('اسم المريض')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone')
                    ->label('رقم الهاتف')
                    ->searchable(),

                TextColumn::make('insurance_number')
                    ->label('الرقم التأميني')
                    ->searchable(),

                TextColumn::make('company.name')
                    ->label('شركة التأمين')
                    ->sortable(),

                TextColumn::make('file_number')
                    ->label('رقم الملف')
                    ->searchable(),

                TextColumn::make('remaining_amount')
                    ->label('المتبقي')
                    ->money('EGP'),

                TextColumn::make('age')
                    ->label('السن'),

                TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime('Y-m-d H:i'),

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
