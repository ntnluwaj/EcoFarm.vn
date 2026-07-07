<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationLabel = 'Danh mục Phân loại';
    
    protected static ?string $modelLabel = 'Danh mục';
    
    protected static ?string $pluralModelLabel = 'Danh mục Phân loại';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(100)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null)
                    ->label('Tên danh mục phân loại'),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(100)
                    ->unique(ignoreRecord: true)
                    ->label('Đường dẫn Slug (SEO)'),

                Select::make('parent_id')
                    ->relationship('parent', 'name')
                    ->placeholder('Chọn danh mục gốc nếu có')
                    ->label('Danh mục cấp cha'),

                FileUpload::make('image_url')
                    ->image()
                    ->directory('uploads/categories')
                    ->label('Hình ảnh đại diện danh mục'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Ảnh đại diện'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Tên danh mục'),
                TextColumn::make('parent.name')
                    ->placeholder('Danh mục gốc')
                    ->label('Danh mục cha'),
                TextColumn::make('slug')
                    ->label('Đường dẫn SEO'),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Tables\Actions\EditAction::make(),
                \Filament\Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    \Filament\Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}