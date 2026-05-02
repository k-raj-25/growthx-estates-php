<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsEventsItemResource\Pages;
use App\Models\NewsEventsItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NewsEventsItemResource extends Resource
{
    protected static ?string $model = NewsEventsItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationLabel = 'News & events';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('section')
                ->options([
                    'news' => 'News',
                    'events' => 'Events',
                ])
                ->required()
                ->default('news'),
            Forms\Components\TextInput::make('title')->required()->maxLength(200),
            Forms\Components\Textarea::make('summary')->rows(4)->columnSpanFull()->nullable(),
            Forms\Components\TextInput::make('image')->maxLength(255)->nullable(),
            Forms\Components\TextInput::make('image_url')->url()->maxLength(500)->nullable(),
            Forms\Components\TextInput::make('link_url')->url()->maxLength(500)->nullable(),
            Forms\Components\Toggle::make('is_published')->default(true)->required(),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0)->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('section')->badge()->sortable(),
                Tables\Columns\TextColumn::make('title')->searchable()->sortable()->limit(40),
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
            'index' => Pages\ListNewsEventsItems::route('/'),
            'create' => Pages\CreateNewsEventsItem::route('/create'),
            'edit' => Pages\EditNewsEventsItem::route('/{record}/edit'),
        ];
    }
}
