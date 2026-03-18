<?php

namespace App\Filament\Resources\Expenses\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;

class ExpensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label('اسم المصروف')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('price')
                    ->label('السعر')
                    ->money('EGP')
                    ->sortable(),

                ImageColumn::make('image')
                    ->label('الصورة')
                    ->disk('public'),

                TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime('Y-m-d h:i A')
                    ->sortable(),

            ])
            
            ->filters([Filter::make('created_at')
    ->label('اليوم')
    ->form([
        DatePicker::make('date')
            ->label('اختر اليوم')
            ->default(now()),
    ])
    ->query(function (Builder $query, array $data) {
        return $query->when(
            $data['date'],
            fn ($query) => $query->whereDate('created_at', $data['date'])
        );
    }),
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