<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CareersSettingsResource\Pages;
use App\Models\CareersSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CareersSettingsResource extends Resource
{
    protected static ?string $model = CareersSettings::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Careers settings';

    public static function canCreate(): bool
    {
        return CareersSettings::query()->count() === 0;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('hr_email')
                ->email()
                ->required()
                ->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hr_email')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCareersSettings::route('/'),
            'create' => Pages\CreateCareersSettings::route('/create'),
            'edit' => Pages\EditCareersSettings::route('/{record}/edit'),
        ];
    }
}
