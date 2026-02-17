<?php

namespace App\Filament\Resources\Doctors\Schemas;
           use Filament\Forms\Components\TagsInput;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DoctorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->label('اسم الدكتور')
                    ->required()
                    ->maxLength(255),

                TextInput::make('phone')
                    ->label('رقم الهاتف')
                    ->required()
                    ->tel(),

                FileUpload::make('image')
                    ->label('صورة الدكتور')
                    ->image()
                    ->directory('doctors')
                    ->maxSize(1024), // 1MB كحد أقصى


TagsInput::make('working_hours')
    ->label('مواعيد العمل')
    ->placeholder('مثال: Saturday:10:00-5:00')
    ->separator(',')
    ->required()


            ]);
    }
}
