<?php

namespace App\Filament\Resources\Appointments\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LabRequestsRelationManager extends RelationManager
{
    protected static string $relationship = 'labRequests';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('lab_id')
                    ->relationship('lab', 'name')
                    ->required()
           
                    ->label('المعمل'),

                TextInput::make('request_name')
                    ->required()
                    ->maxLength(255)
                    ->label('اسم التحليل'),

                Select::make('status')
                    ->options([
                        'pending' => 'قيد الانتظار',
                        'done' => 'تم',
                        'canceled' => 'ملغي',
                    ])
                    ->required()
                    ->label('الحالة'),

                TextInput::make('price')
                    ->numeric()
                    ->required()
                    ->label('السعر'),

                TextInput::make('paid')
                    ->numeric()
                    ->default(0)
                    ->label('المدفوع'),
 Select::make('patient_id')
    ->relationship('patient', 'name')
    ->searchable()
    ->required()
    ->label('المريض'),
                TextInput::make('remaining')
                    ->numeric()
                    ->default(0)
                    ->label('المتبقي'),

                Textarea::make('notes')
                    ->columnSpanFull()
                    ->label('ملاحظات'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('request_name')
            ->columns([

                TextColumn::make('request_name')
                    ->label('اسم التحليل')
                    ->searchable(),
                   


                TextColumn::make('lab.name')
                    ->label('المعمل')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('الحالة')
                    ->badge(),

                TextColumn::make('price')
                    ->label('السعر')
                    ->money('EGP'),

                TextColumn::make('paid')
                    ->label('المدفوع')
                    ->money('EGP'),

                TextColumn::make('remaining')
                    ->label('المتبقي')
                    ->money('EGP'),
            ])
            ->headerActions([
                CreateAction::make()->label('إضافة طلب معمل'),
            
            // هنا بناخد المريض من الحجز

            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
