<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Builder;

class MissedAppointmentsTable extends TableWidget
{protected static ?int $sort = 2;
    protected static ?string $heading = 'الحجوزات التي لم تحضر';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Appointment::query()
                    ->where('status', 'absent')
                    ->with(['patient','doctor'])
            )

            ->columns([
                TextColumn::make('patient.name')
                    ->label('اسم المريض')
                    ->searchable(),

                TextColumn::make('doctor.name')
                    ->label('الدكتور'),

    
            ])

            ->filters([
                //
            ])

            ->headerActions([
                //
            ])

            ->recordActions([
        Action::make('whatsapp')
    ->label('واتساب')
    ->icon('heroicon-o-chat-bubble-left-right')
    ->url(fn ($record) =>
        'https://wa.me/2' . $record->patient->phone .
        '?text=' . urlencode(
            "👋 مرحبًا {$record->patient->name}\n\n" .
            "📢 تذكير بموعدك\n" .
            "👨‍⚕️ الدكتور: {$record->doctor->name}\n" .
            "📅 التاريخ: {$record->appointment_date}\n" .
            "⏰ الساعة: {$record->appointment_time}\n\n" .
            "📍 في انتظارك، نتمنى لك يوم سعيد 🌷"
        )
    )
    ->openUrlInNewTab(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}