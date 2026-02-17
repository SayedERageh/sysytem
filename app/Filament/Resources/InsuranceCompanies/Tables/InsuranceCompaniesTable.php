<?php

namespace App\Filament\Resources\InsuranceCompanies\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class InsuranceCompaniesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label('اسم شركة التأمين')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('patients_count')
                    ->label('عدد المرضى')
                    ->counts('patients'),

                TextColumn::make('prices_count')
                    ->label('عدد الخدمات')
                    ->counts('prices'),

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
