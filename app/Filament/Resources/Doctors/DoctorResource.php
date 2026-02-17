<?php

namespace App\Filament\Resources\Doctors;

use App\Filament\Resources\Doctors\Pages\CreateDoctor;
use App\Filament\Resources\Doctors\Pages\EditDoctor;
use App\Filament\Resources\Doctors\Pages\ListDoctors;
use App\Filament\Resources\Doctors\Schemas\DoctorForm;
use App\Filament\Resources\Doctors\Tables\DoctorsTable;
use App\Models\Doctor;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

protected static ?string $navigationLabel = 'الدكتور';
protected static ?string $pluralModelLabel = 'الدكتور';
protected static ?string $modelLabel = 'الدكتور';

// مكانه في القائمة
protected static string|UnitEnum|null $navigationGroup = 'إدارة الدكتور';
protected static ?int $navigationSort = 4;
protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser; // أيقونة مناسبة

    public static function form(Schema $schema): Schema
    {
        return DoctorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DoctorsTable::configure($table);
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
            'index' => ListDoctors::route('/'),
            'create' => CreateDoctor::route('/create'),
            'edit' => EditDoctor::route('/{record}/edit'),
        ];
    }
}
