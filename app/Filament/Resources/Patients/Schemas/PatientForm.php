<?php

namespace App\Filament\Resources\Patients\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class PatientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->label('اسم المريض')
                    ->required()
                    ->maxLength(255),

                TextInput::make('phone')
                    ->label('رقم الهاتف')
                    ->tel()
                    ->required(),

                TextInput::make('insurance_number')
                    ->label('الرقم التأميني')
                    ->required(),

                Select::make('insurance_company_id')
                    ->label('شركة التأمين')
                    ->relationship('company', 'name')
                    ->required(),

                TextInput::make('file_number')
                    ->label('رقم الملف')
                    ->required(),

                TextInput::make('remaining_amount')
                    ->label('المتبقي')
                    ->numeric()
                    ->default(0),

                TextInput::make('age')
                    ->label('السن')
                    ->numeric()
                    ->required(),

            ]);
    }
}
