<?php

namespace App\Filament\Doctor\Resources\Appointments\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Hidden;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class TeethProcedureRelationManager extends RelationManager
{
    // اسم العلاقة في موديل Appointment
    protected static string $relationship = 'teethProcedures';

    protected static ?string $recordTitleAttribute = 'procedure';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // هذا الحقل يخلي patient_id يتسجل تلقائي من الـ Appointment
                Hidden::make('patient_id')
                    ->default(fn ($livewire, $get) => $livewire->ownerRecord->patient_id),

                TextInput::make('tooth_number')
                    ->label('رقم السن')
                  
                    ->required(),

                TextInput::make('procedure')
                    ->label('الإجراء الحالي')
                    ->required()
                    ->maxLength(255),

                Textarea::make('notes')->label('ملاحظات'),

                TextInput::make('next_procedure')
                    ->label('الإجراء القادم')
                    ->maxLength(255),

                Textarea::make('next_notes')->label('ملاحظات الزيارة القادمة'),

                TextInput::make('w_l')
                    ->label('طول العصب')
                    ->numeric(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tooth_number')
                    ->label('السن')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('procedure')
                    ->label('الإجراء')
                    ->searchable(),

                TextColumn::make('next_procedure')
                    ->label('الإجراء القادم')
                    ->toggleable(),

                TextColumn::make('w_l')
                    ->label('WL')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([])
            ->headerActions([
                CreateAction::make(),
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