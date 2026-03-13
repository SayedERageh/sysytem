<?php

namespace App\Filament\Doctor\Resources\Appointments\Tables;

use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
class AppointmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
        TextColumn::make('patient.name')
    ->label('المريض')
    ->sortable()
    ->searchable()
    ->formatStateUsing(function ($state, $record) {
        // id المريض
        $patientId = $record->patient->id;

        // الرابط المباشر للـ edit في Doctor Panel
        $url = url("/doctor/patients/{$patientId}/edit");

        // نرجع HTML للرابط
        return '<a href="'.$url.'" class="text-blue-600 hover:underline">'.$state.'</a>';
    })
    ->html(), // مهم جداً عشان Filament تعرف أن الكود HTML


                // اسم شركة التأمين
                TextColumn::make('company.name')
                    ->label('شركة التأمين')
                    ->sortable()
                    ->searchable(),

                // اسم الخدمة
                TextColumn::make('service_name')
                    ->label('الخدمة')
                    ->sortable()
                    ->searchable(),
                    
            ])
         
            ->filters([

                Filter::make('appointment_date')
                    ->label('اليوم')
                    ->form([
                        DatePicker::make('date')
                            ->label('اختر اليوم')
                            ->default(now()),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when(
                            $data['date'],
                            fn ($query) => $query->whereDate('appointment_date', $data['date'])
                        );
                    }),

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