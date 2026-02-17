<?php

namespace App\Filament\Resources\InsuranceCompanies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InsuranceCompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('name')
                    ->label('اسم شركة التأمين')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

            ]);
    }
}
