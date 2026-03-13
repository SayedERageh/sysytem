<?php

namespace App\Filament\Doctor\pages;

use Filament\Pages\Page;
use App\Filament\Doctor\Widgets\CalendarWidget;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class Calendar extends Page
{
protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;
protected static string|UnitEnum|null $navigationGroup = 'إدارة المواعيد';

    protected static ?string $navigationLabel = 'مواعيدي اليوم  ';

    protected static ?string $title = 'مواعيدي اليوم ';


    protected function getHeaderWidgets(): array
    {
        return [
            CalendarWidget::class,
        ];
    }
}