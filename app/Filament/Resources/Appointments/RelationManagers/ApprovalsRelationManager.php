<?php

namespace App\Filament\Resources\Appointments\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

use Filament\Tables\Table;

class ApprovalsRelationManager extends RelationManager
{
    protected static string $relationship = 'approvals';
        protected static ?string $title = 'صور موفقات المريض ';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
Select::make('patient_id')
    ->relationship('appointment.patient', 'name')
    ->hidden() // لو مش عايز المستخدم يغيرها
    ->default(fn ($record) => $record->appointment->patient_id ?? null),
                TextInput::make('name')
                    ->label('اسم الموافقة')
                    ->maxLength(255),

                Textarea::make('notes')
                    ->label('ملاحظات'),

                FileUpload::make('images')
                    ->label('صور الموافقة')
                    ->multiple()
                    ->image()
                    ->disk('public')
                    ->directory('approvals')
                    ->reorderable()
                    ->downloadable()
                    ->previewable()
                    ->openable(),

                Toggle::make('approved')
                    ->label('تمت الموافقة')
                    ->default(false),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable(),

                IconColumn::make('approved')
                    ->label('الموافقة')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('التاريخ')
                    ->dateTime(),
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
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}