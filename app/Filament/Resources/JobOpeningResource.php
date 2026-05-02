<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobOpeningResource\Pages;
use App\Models\JobOpening;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JobOpeningResource extends Resource
{
    protected static ?string $model = JobOpening::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->required()->maxLength(200),
            Forms\Components\TextInput::make('department')->maxLength(120)->nullable(),
            Forms\Components\TextInput::make('location')->maxLength(200)->nullable(),
            Forms\Components\Select::make('employment_type')
                ->options([
                    'full_time' => 'Full time',
                    'part_time' => 'Part time',
                    'internship' => 'Internship',
                    'contract' => 'Contract',
                ])
                ->default('full_time')
                ->required(),
            Forms\Components\Textarea::make('description')->required()->rows(4)->columnSpanFull(),
            Forms\Components\Textarea::make('responsibilities')->rows(6)->columnSpanFull()->nullable(),
            Forms\Components\Textarea::make('qualifications')->rows(6)->columnSpanFull()->nullable(),
            Forms\Components\Toggle::make('is_published')->default(true)->required(),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0)->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->sortable()->limit(40),
                Tables\Columns\TextColumn::make('department')->sortable(),
                Tables\Columns\TextColumn::make('location')->toggleable(),
                Tables\Columns\TextColumn::make('employment_type')->badge(),
                Tables\Columns\IconColumn::make('is_published')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->numeric()->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobOpenings::route('/'),
            'create' => Pages\CreateJobOpening::route('/create'),
            'edit' => Pages\EditJobOpening::route('/{record}/edit'),
        ];
    }
}
