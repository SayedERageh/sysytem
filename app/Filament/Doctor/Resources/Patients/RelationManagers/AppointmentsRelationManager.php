<?php

namespace App\Filament\Doctor\Resources\Patients\RelationManagers;

use App\Models\InsuranceCompany;
use App\Models\InsurancePrice;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AppointmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'appointments';

    protected static ?string $title = 'الحجوزات';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
       ->recordTitleAttribute('service_name')
        ->columns([

            TextColumn::make('doctor.name')
                ->label('الدكتور')
                ->searchable(),

            TextColumn::make('appointment_date')
                ->label('تاريخ الحجز')
                ->date(),

            TextColumn::make('diagnosis_chart')
                ->label('تشخيص الحالة')
                ->limit(30),

            TextColumn::make('teeth_number')
                ->label('رقم السن')
                ->formatStateUsing(fn ($state) => is_array($state) ? implode(', ', $state) : $state),

            TextColumn::make('teeth_length')
                ->label('طول العصب (W . L)'),

            TextColumn::make('next_session')
                ->label('الزيارة القادمة')
                ->dateTime(),

            TextColumn::make('notes')
                ->label('ملاحظات')
                ->limit(30),
            ])
            ->headerActions([
                CreateAction::make()->label('إضافة حجز'),
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