<?php

namespace App\Filament\Resources\Labs\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RequestsRelationManager extends RelationManager
{
    protected static string $relationship = 'requests';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('patient_id')
                    ->label('المريض')
                    ->relationship('patient', 'name')
                    ->required(),

                TextInput::make('name')
                    ->label('اسم الطلب')
                    ->required()
                    ->maxLength(255),

                TextInput::make('price')
                    ->label('السعر')
                    ->numeric()
                    ->required(),

                TextInput::make('paid')
                    ->label('المدفوع')
                    ->numeric()
                    ->default(0),

                TextInput::make('remaining')
                    ->label('المتبقي')
                    ->numeric()
                    ->default(0),

                Select::make('status')
                    ->label('الحالة')
                    ->options([
                        'requested' => 'تم الطلب',
                        'received' => 'تم الاستلام',
                        'rejected' => 'تم الرفض',
                    ])
                    ->default('requested'),

                Textarea::make('notes')
                    ->label('ملاحظات')
                    ->rows(2),
            
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('requests')
            ->columns([
                         TextColumn::make('patient.name')->label('المريض')->sortable()->searchable(),
                TextColumn::make('name')->label('اسم الطلب')->sortable()->searchable(),
                TextColumn::make('price')->label('السعر')->money('EGP'),
                TextColumn::make('paid')->label('المدفوع')->money('EGP'),
                TextColumn::make('remaining')->label('المتبقي')->money('EGP'),
                TextColumn::make('status')->label('الحالة')->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
