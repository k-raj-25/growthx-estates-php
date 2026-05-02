<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteEnquiryResource\Pages;
use App\Models\SiteEnquiry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class SiteEnquiryResource extends Resource
{
    protected static ?string $model = SiteEnquiry::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox';

    protected static ?string $navigationLabel = 'Enquiries';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return true;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('enquiry_type')->disabled(),
            Forms\Components\TextInput::make('name')->disabled(),
            Forms\Components\TextInput::make('phone')->disabled(),
            Forms\Components\Textarea::make('message')->disabled()->rows(5)->columnSpanFull(),
            Forms\Components\Select::make('property_id')
                ->relationship('property', 'name')
                ->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('enquiry_type')->badge()->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->limit(30),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('property.name')->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()->label('View'),
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
            'index' => Pages\ListSiteEnquiries::route('/'),
            'edit' => Pages\EditSiteEnquiry::route('/{record}/edit'),
        ];
    }
}
