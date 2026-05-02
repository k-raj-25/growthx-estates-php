<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->required()->maxLength(200),
            Forms\Components\TextInput::make('slug')
                ->maxLength(220)
                ->helperText('Leave blank to auto-generate from the title.'),
            Forms\Components\Textarea::make('excerpt')->rows(3)->columnSpanFull()->nullable(),
            Forms\Components\RichEditor::make('body')->required()->columnSpanFull(),
            Forms\Components\TextInput::make('featured_image')->maxLength(255)->nullable()->helperText('Stored path under storage, e.g. blog/photo.jpg'),
            Forms\Components\TextInput::make('featured_image_url')->url()->maxLength(500)->nullable(),
            Forms\Components\Select::make('author_id')
                ->relationship('author', 'name')
                ->searchable()
                ->preload()
                ->nullable(),
            Forms\Components\Toggle::make('is_published')->default(false)->required(),
            Forms\Components\DateTimePicker::make('published_at')->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->sortable()->limit(50),
                Tables\Columns\TextColumn::make('author.name')->toggleable(),
                Tables\Columns\IconColumn::make('is_published')->boolean(),
                Tables\Columns\TextColumn::make('published_at')->dateTime()->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
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
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
