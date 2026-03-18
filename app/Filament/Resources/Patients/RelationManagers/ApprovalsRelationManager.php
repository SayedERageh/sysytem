<?php

namespace App\Filament\Resources\Patients\RelationManagers;

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
use Filament\Tables\Columns\FileColumn;

use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ApprovalsRelationManager extends RelationManager
{
    protected static string $relationship = 'approvals';
    protected static ?string $title = 'صور موفقات المريض';

    // -------------------
    // الفورم لإضافة/تعديل الموافقات
    // -------------------
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('اسم الموافقة')
                    ->maxLength(255)
                    ->required(),

                Textarea::make('notes')
                    ->label('ملاحظات'),

                FileUpload::make('files')
                    ->label('صور وملفات')
                    ->multiple()
                    ->disk('public')
                    ->directory('uploads')
                    ->acceptedFileTypes([
                        'image/*',
                        'application/pdf',
                        'application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    ])
                    ->downloadable()
                    ->openable()
                    ->previewable(),

                Toggle::make('approved')
                    ->label('تمت الموافقة')
                    ->default(false),

                // اختيار الحجز الموجود مسبقًا
                Select::make('appointment_id')
                    ->label('اختر الحجز')
                    ->required()
                    ->options(function ($livewire) {
                        $patient = $livewire->getOwnerRecord();
                        return $patient->appointments->pluck('appointment_date', 'id')->map(function ($date, $id) use ($patient) {
                            $appointment = $patient->appointments->find($id);
                            return $appointment ? $appointment->appointment_date->format('Y-m-d').' - '.$appointment->service_name : '';
                        })->toArray();
                    })
                    ->searchable(),
            ]);
    }

    // -------------------
    // الجدول لعرض الموافقات
    // -------------------
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('اسم الموافقة')
                    ->searchable(),

                IconColumn::make('approved')
                    ->label('الموافقة')
                    ->boolean(),


                TextColumn::make('appointment.appointment_date')
                    ->label('تاريخ الحجز')
                    ->date(),

                TextColumn::make('appointment.service_name')
                    ->label('الخدمة'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataUsing(function (array $data, $livewire) {
                        // ربط الموافقة بالمريض الحالي
                        $patient = $livewire->getOwnerRecord();
                        $data['patient_id'] = $patient->id;
                        return $data;
                    }),
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