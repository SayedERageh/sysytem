<?php

namespace App\Filament\Resources\Labs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class LabForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->label('اسم المعمل')
                    ->required()
                    ->maxLength(255),

                TextInput::make('paid')
                    ->label('المدفوع')
                    ->numeric()
                    ->required(),

                TextInput::make('remaining')
                    ->label('المتبقي')
                    ->numeric()
                    ->required(),

                Textarea::make('notes')
                    ->label('ملاحظات')
                    ->rows(3),

            ]);
    }
}
