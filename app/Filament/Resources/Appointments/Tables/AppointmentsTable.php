<?php

namespace App\Filament\Resources\Appointments\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;

class AppointmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->defaultSort('appointment_date')

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

                TextColumn::make('doctor.name')
                    ->label('الدكتور')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('appointment_date')
                    ->label('التاريخ')
                    ->date(),

           
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

                Action::make('pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-printer')
                    ->url(fn ($record) => route('appointment.pdf', $record->id))
                    ->openUrlInNewTab(),

                Action::make('whatsapp')
                    ->label('واتساب')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->url(fn ($record) =>
                        'https://wa.me/2'.$record->patient->phone.'?text='.urlencode(
                            "مرحبًا {$record->patient->name}\n".
                            "نشكرك علي حجزك مع الدكتور {$record->doctor->name}\n".
                            "الخدمة: {$record->service_name}\n".
                            "التاريخ: {$record->appointment_date}"
                        )
                    )
                    ->openUrlInNewTab(),

            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}