<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class ExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->label('اسم المصروف')
                    ->required()
                    ->maxLength(255),

                TextInput::make('price')
                    ->label('السعر')
                    ->numeric()
                    ->required(),

                FileUpload::make('image')
                    ->label('صورة المصروف')
                    ->image()
                    ->directory('expenses')
                    ->disk('public')
                    ->nullable(),

            ]);
    }
}