<?php

namespace App\Filament\Resources\Doctors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class DoctorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('name')
                    ->label('اسم الدكتور')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone')
                    ->label('رقم الهاتف')
                    ->searchable(),

                ImageColumn::make('image')
                    ->label('صورة الدكتور')
                    ->disk('public') // حسب مكان التخزين
                    ->height(50)
                    ->width(50),

                TextColumn::make('working_hours')
                    ->label('مواعيد العمل')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return '-';
                        $hours = json_decode($state, true);
                        if (!$hours) return $state;
                        $formatted = [];
                        foreach ($hours as $day => $time) {
                            $formatted[] = ucfirst($day) . ': ' . $time;
                        }
                        return implode(' | ', $formatted);
                    }),

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
