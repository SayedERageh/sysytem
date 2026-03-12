<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\CalendarWidget;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class Calendar extends Page
{
protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;
protected static string|UnitEnum|null $navigationGroup = 'إدارة الحجوزات';

    protected static ?string $navigationLabel = 'مواعيد الدكتره ';

    protected static ?string $title = 'مواعيد الزيارت والدكتره';


    protected function getHeaderWidgets(): array
    {
        return [
            CalendarWidget::class,
        ];
    }
}