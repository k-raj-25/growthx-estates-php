<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Models\Property;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    /** @param array<mixed>|string|null $state */
    public static function jsonEncodeField($state): string
    {
        if ($state === null || $state === '') {
            return '[]';
        }
        if (is_string($state)) {
            return $state;
        }

        return (string) json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /** @return array<mixed> */
    public static function jsonDecodeField(?string $state): array
    {
        $raw = trim((string) ($state ?? ''));
        if ($raw === '') {
            return [];
        }
        try {
            $decoded = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            return [];
        }

        return is_array($decoded) ? $decoded : [];
    }

    public static function form(Form $form): Form
    {
        $jsonField = fn (string $name, ?string $label = null): Forms\Components\Textarea =>
            Forms\Components\Textarea::make($name)
                ->label($label ?? $name)
                ->rows(12)
                ->columnSpanFull()
                ->rules(['json'])
                ->afterStateHydrated(function (Forms\Components\Textarea $component, $state) {
                    $component->state(self::jsonEncodeField($state));
                })
                ->dehydrateStateUsing(fn (?string $state): array => self::jsonDecodeField($state));

        return $form->schema([
            Forms\Components\Section::make('Basics')->schema([
                Forms\Components\TextInput::make('name')->required()->maxLength(200),
                Forms\Components\TextInput::make('slug')
                    ->maxLength(140)
                    ->helperText('Leave blank to auto-generate.'),
                Forms\Components\Select::make('city_id')
                    ->relationship('city', 'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('location')->required()->maxLength(240),
                Forms\Components\TextInput::make('price_display')->required()->maxLength(120),
                Forms\Components\TextInput::make('rating')->numeric()->default(4.50)->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'Ready to move' => 'Ready to move',
                        'Under construction' => 'Under construction',
                        'New launch' => 'New launch',
                    ])
                    ->required(),
                Forms\Components\Select::make('project_type')
                    ->options(Property::projectTypeOptions())
                    ->required(),
                Forms\Components\TextInput::make('brochure_url')->maxLength(500)->url()->nullable(),
                Forms\Components\Toggle::make('is_published')->default(true)->required(),
                Forms\Components\TextInput::make('sort_order')->numeric()->default(0)->required(),
            ])->columns(2),
            Forms\Components\Section::make('Marketing')->schema([
                Forms\Components\Textarea::make('description')->required()->columnSpanFull()->rows(5),
                Forms\Components\TextInput::make('developer_name')->required()->maxLength(200),
                Forms\Components\Textarea::make('about_developer')->required()->columnSpanFull()->rows(4),
                Forms\Components\TextInput::make('rera_id')->required()->maxLength(120),
                Forms\Components\TextInput::make('project_size')->required()->maxLength(200),
                Forms\Components\TextInput::make('map_embed_url')->required()->maxLength(800)->url(),
            ]),
            Forms\Components\Section::make('Structured JSON')->schema([
                $jsonField('images', 'Images (JSON array of image URLs)')
                    ->helperText('Example: ["https://example.com/a.jpg"]'),
                $jsonField('amenities', 'Amenities (JSON array of strings)')
                    ->helperText('Example: ["Infinity pool","Concierge"]'),
                $jsonField('videos', 'Videos (JSON array of objects with title + embed_url)')
                    ->helperText('Example: [{"title":"Walkthrough","embed_url":"https://www.youtube.com/embed/abc"}]'),
                $jsonField('faq', 'FAQ (JSON array of objects with q + a)')
                    ->helperText('Example: [{"q":"When is possession?","a":"Timeline is shared after booking."}]'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable()->limit(40),
                Tables\Columns\TextColumn::make('city.name')->sortable(),
                Tables\Columns\TextColumn::make('status')->sortable()->badge(),
                Tables\Columns\TextColumn::make('project_type')->sortable(),
                Tables\Columns\IconColumn::make('is_published')->boolean(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}
