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
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\BadgeColumn;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    
    protected static ?string $navigationLabel = 'Sản phẩm Vật tư';

    protected static ?string $navigationGroup = 'Danh mục & Sản phẩm';

    protected static ?int $navigationSort = 1;
    
    protected static ?string $modelLabel = 'Sản phẩm vật tư';
    
    protected static ?string $pluralModelLabel = 'Quản lý Sản phẩm Vật tư';

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
                    ->label('Giá bán niêm yết'),

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
                ImageColumn::make('primary_image_url')
                    ->label('Hình ảnh')
                    ->square()
                    ->size(46)
                    ->extraImgAttributes(['class' => 'rounded-xl shadow-sm border border-slate-200 object-cover']),

                TextColumn::make('name')
                    ->label('Sản phẩm vật tư')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Product $record): string => ($record->brand->name ?? 'EcoFarm') . ' · ' . ($record->packaging ?? $record->unit))
                    ->wrap(),

                TextColumn::make('category.name')
                    ->label('Phân loại danh mục')
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        str_contains($state, 'Thuốc') => 'info',
                        str_contains($state, 'Phân') => 'warning',
                        str_contains($state, 'Hạt') => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('price')
                    ->label('Giá bán niêm yết')
                    ->money('VND')
                    ->sortable()
                    ->weight('black')
                    ->color('success'),

                TextColumn::make('stock')
                    ->label('Tồn kho bến bãi')
                    ->formatStateUsing(fn ($state, Product $record) => $state <= 10 ? "🔥 Sắp hết: {$state} {$record->unit}" : "✔ Còn: {$state} {$record->unit}")
                    ->badge()
                    ->color(fn ($state, Product $record) => $record->stock <= 10 ? 'danger' : 'success')
                    ->sortable(),

                ToggleColumn::make('status')
                    ->label('Trạng thái mở bán')
                    ->onColor('success')
                    ->offColor('gray'),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Lọc theo danh mục'),

                \Filament\Tables\Filters\Filter::make('low_stock')
                    ->label('🔥 Hàng sắp hết (≤ 10)')
                    ->query(fn ($query) => $query->where('stock', '<=', 10)),
            ])
            ->actions([
                \Filament\Tables\Actions\ActionGroup::make([
                    \Filament\Tables\Actions\EditAction::make()->color('primary'),
                    \Filament\Tables\Actions\DeleteAction::make()->color('danger'),
                ])
                ->label('Thao tác')
                ->icon('heroicon-m-ellipsis-horizontal')
                ->color('gray')
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}