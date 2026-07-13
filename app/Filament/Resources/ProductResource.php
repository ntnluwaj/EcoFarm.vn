<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload; // 🌟 Thư viện FileUpload
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    
    protected static ?string $navigationLabel = 'Sản phẩm Vật tư';
    
    protected static ?string $modelLabel = 'Sản phẩm';
    
    protected static ?string $pluralModelLabel = 'Kho Sản phẩm Vật tư';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(150)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null)
                    ->label('Tên thương mại sản phẩm'),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(150)
                    ->unique(ignoreRecord: true)
                    ->label('Đường dẫn Slug (SEO)'),

                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label('Danh mục phân loại'),

                Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->nullable()
                    ->searchable()
                    ->preload()
                    ->label('Thương hiệu / Nhà sản xuất'),

                FileUpload::make('images')
                    ->multiple() 
                    ->image() 
                    ->reorderable() 
                    ->directory('products') 
                    ->disk('public')
                    ->columnSpanFull() 
                    ->label('Bộ sưu tập hình ảnh vật tư (Nhiều ảnh Slide)'),

                TextInput::make('price')
                    ->numeric()
                    ->required()
                    ->prefix('VND')
                    ->label('Giá bán lẻ niêm yết (B2C)'),



                TextInput::make('unit')
                    ->required()
                    ->maxLength(20)
                    ->placeholder('Ví dụ: Chai, Gói, Bao, Can')
                    ->label('Đơn vị tính cơ sở'),

                TextInput::make('packaging')
                    ->required()
                    ->maxLength(50)
                    ->placeholder('Ví dụ: Thùng 24 chai, Bao 50kg')
                    ->label('Quy cách đóng gói'),

                TextInput::make('stock')
                    ->numeric()
                    ->default(0)
                    ->required()
                    ->label('Số lượng hàng tồn kho thực tế'),

                Toggle::make('status')
                    ->default(true)
                    ->label('Trạng thái mở bán công khai'),

                RichEditor::make('description')
                    ->nullable()
                    ->columnSpanFull()
                    ->label('Bài viết mô tả chi tiết thành phần, công dụng'),

                RichEditor::make('usage_guide')
                    ->nullable()
                    ->columnSpanFull()
                    ->label('Hướng dẫn kỹ thuật bón tưới, liều lượng an toàn'),

                Forms\Components\Repeater::make('variants')
                    ->relationship('variants')
                    ->schema([
                        Forms\Components\TextInput::make('capacity')
                            ->label('Dung tích / Trọng lượng')
                            ->placeholder('Ví dụ: 100ml, 500ml, 1kg')
                            ->required(),
                        Forms\Components\TextInput::make('price')
                            ->label('Giá bán lẻ')
                            ->numeric()
                            ->required()
                            ->prefix('VND'),
                        Forms\Components\TextInput::make('stock')
                            ->label('Số lượng tồn kho')
                            ->numeric()
                            ->required()
                            ->default(0),
                    ])
                    ->columns(3)
                    ->columnSpanFull()
                    ->label('Danh sách phiên bản dung tích (Nếu có nhiều loại khác nhau)'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('images')
                    ->label('Hình ảnh')
                    ->stacked()
                    ->circular()
                    ->limit(3),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->label('Tên vật tư'),
                TextColumn::make('category.name')
                    ->label('Danh mục'),
                TextColumn::make('price')
                    ->money('VND')
                    ->sortable()
                    ->label('Giá bán lẻ'),

                TextColumn::make('stock')
                    ->sortable()
                    ->label('Tồn kho'),
                TextColumn::make('unit')
                    ->label('ĐVT'),
                IconColumn::make('status')
                    ->boolean()
                    ->label('Đang bán'),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Lọc theo danh mục'),
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
            // Cấu hình các trang điều phối của Filament
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}