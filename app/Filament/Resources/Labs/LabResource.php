<?php

namespace App\Filament\Resources\Labs;

use App\Filament\Resources\Labs\Pages\CreateLab;
use App\Filament\Resources\Labs\Pages\EditLab;
use App\Filament\Resources\Labs\Pages\ListLabs;
use App\Filament\Resources\Labs\RelationManagers\RequestsRelationManager;
use App\Filament\Resources\Labs\Schemas\LabForm;
use App\Filament\Resources\Labs\Tables\LabsTable;
use App\Models\Lab;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LabResource extends Resource
{
    protected static ?string $model = Lab::class;

protected static ?string $navigationLabel = 'المعامل';
protected static ?string $pluralModelLabel = 'المعامل';
protected static ?string $modelLabel = 'المعامل';

// مكانه في القائمة
protected static string|UnitEnum|null $navigationGroup = 'إدارة المعامل';
protected static ?int $navigationSort = 5;
protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice; // أيقونة مناسبة للمعامل

    public static function form(Schema $schema): Schema
    {
        return LabForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LabsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RequestsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLabs::route('/'),
            'create' => CreateLab::route('/create'),
            'edit' => EditLab::route('/{record}/edit'),
        ];
    }
}
