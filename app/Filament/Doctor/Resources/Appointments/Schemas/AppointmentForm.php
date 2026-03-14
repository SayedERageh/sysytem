<?php

namespace App\Filament\Doctor\Resources\Appointments\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Schema;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // تشخيص الحالة
                Textarea::make('diagnosis_chart')
                    ->label('تشخيص الحالة')
                    ->rows(4),

                // رقم السنة (JSON Tags)
                TagsInput::make('teeth_number')
                    ->label('رقم السن'),

                // طول السن
                TextInput::make('teeth_length')
                ->label('طول العصب (W . L)'),

                // معلومات الزيارة القادمة
                TextInput::make('next_session')
                    ->label('هنعمل اي  الزيارة القادمة'),

                // ملاحظات
                Textarea::make('notes')
                    ->label('ملاحظات')
                    ->rows(3),
            ]);
    }
}