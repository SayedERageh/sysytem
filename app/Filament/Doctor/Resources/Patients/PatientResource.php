<?php

namespace App\Filament\Doctor\Resources\Patients;

use App\Filament\Doctor\Resources\Patients\Pages\CreatePatient;
use App\Filament\Doctor\Resources\Patients\Pages\EditPatient;
use App\Filament\Doctor\Resources\Patients\Pages\ListPatients;
use App\Filament\Doctor\Resources\Patients\RelationManagers\AppointmentsRelationManager;
use App\Filament\Doctor\Resources\Patients\RelationManagers\LabRequestsRelationManager;
use App\Filament\Doctor\Resources\Patients\RelationManagers\RadiologiesRelationManager;
use App\Filament\Doctor\Resources\Patients\Schemas\PatientForm;
use App\Filament\Doctor\Resources\Patients\Tables\PatientsTable;
use App\Models\Patient;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;

protected static ?string $navigationLabel = 'المرضى';
protected static ?string $pluralModelLabel = 'المرضى';
protected static ?string $modelLabel = 'مريض';

// مكانه في القائمة
protected static string|UnitEnum|null $navigationGroup = 'إدارة المرضى';
protected static ?int $navigationSort = 1;

// أيقونة مناسبة للمرضى
protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;
    public static function form(Schema $schema): Schema
    {
        return PatientForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PatientsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
           AppointmentsRelationManager::class,
           LabRequestsRelationManager::class,
           RadiologiesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPatients::route('/'),
            'create' => CreatePatient::route('/create'),
            'edit' => EditPatient::route('/{record}/edit'),
        ];
    }
}
