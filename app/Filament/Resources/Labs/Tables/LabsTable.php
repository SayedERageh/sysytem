<?php

namespace App\Filament\Resources\Labs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class LabsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label('اسم المعمل')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('paid')
                    ->label('المدفوع')
                    ->money('EGP')
                    ->sortable(),

                TextColumn::make('remaining')
                    ->label('المتبقي')
                    ->money('EGP')
                    ->sortable(),

                TextColumn::make('requests_count')
                    ->label('عدد الطلبات')
                    ->counts('requests')
                    ->sortable(),

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
