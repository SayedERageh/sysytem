<?php

namespace App\Filament\Doctor\Resources\Appointments;

use App\Filament\Doctor\Resources\Appointments\Pages\CreateAppointment;
use App\Filament\Doctor\Resources\Appointments\Pages\EditAppointment;
use App\Filament\Doctor\Resources\Appointments\Pages\ListAppointments;
use App\Filament\Doctor\Resources\Appointments\Schemas\AppointmentForm;
use App\Filament\Doctor\Resources\Appointments\Tables\AppointmentsTable;
use App\Models\Appointment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
    use Illuminate\Database\Eloquent\Builder;

class AppointmentResource extends Resource

{


    public static function getEloquentQuery(): Builder
    {
        // ناخد الاستعلام الأساسي من Resource
        return parent::getEloquentQuery()
            ->where('doctor_id', auth()->id()); // ID الدكتور المسجل دخول
    }

    // ...

    
protected static ?string $navigationLabel = 'الحجوزات';
protected static ?string $pluralModelLabel = 'الحجوزات';
protected static ?string $modelLabel = 'حجز';

// مكانه في القائمة
protected static string|UnitEnum|null $navigationGroup = 'إدارة حالتي';
protected static ?int $navigationSort = 0;
protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;
    protected static ?string $model = Appointment::class;

    

    public static function form(Schema $schema): Schema
    {
        return AppointmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AppointmentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAppointments::route('/'),
            'create' => CreateAppointment::route('/create'),
            'edit' => EditAppointment::route('/{record}/edit'),
        ];
    }
}
