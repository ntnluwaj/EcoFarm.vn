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

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    
    protected static ?string $navigationLabel = 'Sản phẩm Vật tư';

    protected static ?string $navigationGroup = 'Danh mục & Sản phẩm';

    protected static ?int $navigationSort = 1;
    
    protected static ?string $modelLabel = 'Sản phẩm';
    
    protected static ?string $pluralModelLabel = 'Kho Sản phẩm Vật tư';

    protected static ?string $recordTitleAttribute = 'name';

    public static function canViewAny(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'engineer']);
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()?->role === 'admin';
    }

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
                    ->panelLayout('grid')
                    ->imagePreviewHeight('150px')
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
                    ->label('HÌNH ẢNH')
                    ->square()
                    ->size(54)
                    ->circular(false)
                    ->extraImgAttributes(['class' => 'rounded-3 shadow-xs border']),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->weight('bold')
                    ->description(fn (Product $record): string => 'Quy cách: ' . ($record->packaging ?? 'Tiêu chuẩn') . ' | ĐVT: ' . $record->unit)
                    ->label('TÊN VẬT TƯ & QUY CÁCH'),

                TextColumn::make('priority_flame')
                    ->label('MỨC ƯU TIÊN')
                    ->html()
                    ->state(function (Product $record): string {
                        if ($record->stock > 100) {
                            return '<span class="badge-flame-red"><i class="fa-solid fa-fire"></i>🔥 5 Cháy Rực</span>';
                        } elseif ($record->stock > 20) {
                            return '<span class="badge-flame-yellow"><i class="fa-solid fa-fire"></i>🔥 3 Bén Lửa</span>';
                        } else {
                            return '<span class="badge-tag-gray"><i class="fa-solid fa-fire text-muted"></i>🔥 1 Tắt Ngấm</span>';
                        }
                    }),

                TextColumn::make('category.name')
                    ->label('DANH MỤC')
                    ->badge()
                    ->color('success')
                    ->sortable(),

                TextColumn::make('stock_status')
                    ->label('TRẠNG THÁI KHO')
                    ->html()
                    ->state(function (Product $record): string {
                        if ($record->stock > 50) {
                            return '<span class="badge-status-green"><span class="status-dot-pulse dot-green"></span>Tồn kho dồi dào (' . number_format($record->stock) . ')</span>';
                        } elseif ($record->stock > 0) {
                            return '<span class="badge-flame-yellow"><span class="status-dot-pulse dot-yellow"></span>Sắp hết hàng (' . number_format($record->stock) . ')</span>';
                        } else {
                            return '<span class="badge-flame-red"><span class="status-dot-pulse dot-red"></span>Hết hàng (0)</span>';
                        }
                    }),

                TextColumn::make('price')
                    ->money('VND')
                    ->sortable()
                    ->weight('extrabold')
                    ->color('success')
                    ->alignEnd()
                    ->label('GIÁ BÁN LẺ'),

                TextColumn::make('unit')
                    ->label('ĐVT')
                    ->badge()
                    ->color('gray'),

                \Filament\Tables\Columns\ToggleColumn::make('status')
                    ->label('ĐANG BÁN'),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Lọc theo danh mục'),
            ])
            ->actions([
                \Filament\Tables\Actions\ActionGroup::make([
                    \Filament\Tables\Actions\EditAction::make(),
                    \Filament\Tables\Actions\DeleteAction::make(),
                ])
                ->label('Thao tác')
                ->icon('heroicon-m-ellipsis-vertical')
                ->color('success')
                ->button(),
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