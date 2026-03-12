<?php

namespace App\Filament\Doctor\Resources\Patients\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LabRequestsRelationManager extends RelationManager
{
    protected static string $relationship = 'labRequests';

    protected static ?string $title = 'طلبات المعمل';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Select::make('lab_id')
                    ->label('المعمل')
                    ->relationship('lab', 'name')
                  
                    ->required(),

                TextInput::make('request_name')
                    ->label('اسم الطلب')
                    ->required(),

                TextInput::make('price')
                    ->label('السعر')
                    ->numeric()
                    ->required(),

                TextInput::make('paid')
                    ->label('المدفوع')
                    ->numeric()
                    ->default(0)
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        $price = $get('price') ?? 0;
                        $set('remaining', $price - $state);
                    }),

                TextInput::make('remaining')
                    ->label('المتبقي')
                    ->numeric()
                    ->disabled(),

                Select::make('status')
                    ->label('الحالة')
                    ->options([
                        'pending' => 'في الانتظار',
                        'done' => 'تم',
                        'cancelled' => 'ملغي',
                    ])
                    ->default('pending'),

                Textarea::make('notes')
                    ->label('ملاحظات')
                    ->columnSpanFull(),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('request_name')
            ->columns([

                TextColumn::make('lab.name')
                    ->label('المعمل')
                    ->searchable(),

                TextColumn::make('request_name')
                    ->label('اسم الطلب')
                    ->searchable(),

                TextColumn::make('price')
                    ->label('السعر')
                    ->money('EGP'),

                TextColumn::make('paid')
                    ->label('المدفوع')
                    ->money('EGP'),

                TextColumn::make('remaining')
                    ->label('المتبقي')
                    ->money('EGP'),

                TextColumn::make('status')
                    ->label('الحالة')
                    ->badge(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()->label('إضافة طلب معمل'),
            ])
            ->recordActions([
                EditAction::make()->label('تعديل'),
                DeleteAction::make()->label('حذف'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}