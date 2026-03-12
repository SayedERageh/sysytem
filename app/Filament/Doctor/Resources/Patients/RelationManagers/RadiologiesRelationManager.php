<?php

namespace App\Filament\Doctor\Resources\Patients\RelationManagers;

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
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class RadiologiesRelationManager extends RelationManager
{
        protected static ?string $title = 'صور اشعات المريض ';

    protected static string $relationship = 'radiologies';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('radiology_name')
                    ->label('Radiology Name')
                    ->required()
                    ->maxLength(255),

                FileUpload::make('images')
                    ->label('Radiology Images')
                    ->multiple()
                    ->image()
                    ->disk('public')
                    ->directory('radiologies')
                    ->reorderable()
                    ->downloadable()
                    ->previewable()
                    ->openable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('radiology_name')
            ->columns([
                TextColumn::make('radiology_name')
                    ->searchable(),

                ImageColumn::make('images')
                    ->label('Images')
                    ->stacked()
                    ->limit(3),
            ])
            ->filters([
                //
            ])
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