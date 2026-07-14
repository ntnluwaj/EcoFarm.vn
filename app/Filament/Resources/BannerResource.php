<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Banner Quảng cáo';

    protected static ?string $navigationGroup = 'Truyền thông & Marketing';

    protected static ?int $navigationSort = 2;
    
    protected static ?string $modelLabel = 'Banner';
    
    protected static ?string $pluralModelLabel = 'Danh sách Banner';

    public static function canViewAny(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông tin Banner Slide')
                    ->schema([
                        TextInput::make('title')
                            ->maxLength(150)
                            ->placeholder('Ví dụ: Đồng Hành Cùng Nhà Vườn Việt')
                            ->label('Tiêu đề chính Slide'),

                        TextInput::make('subtitle')
                            ->maxLength(150)
                            ->placeholder('Ví dụ: Giải pháp số nông nghiệp vụ mới 2026')
                            ->label('Badge Phụ đề nổi bật'),

                        TextInput::make('link_url')
                            ->maxLength(255)
                            ->placeholder('Ví dụ: /san-pham hoặc đường dẫn đầy đủ')
                            ->label('Đường dẫn liên kết khi Click'),

                        FileUpload::make('image_path')
                            ->required()
                            ->image()
                            ->directory('banners')
                            ->disk('public')
                            ->label('Hình ảnh Banner Slide (Khuyến nghị: 1200x400px)'),
                    ])->columnSpan(2),

                Section::make('Cài đặt hiển thị')
                    ->schema([
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->label('Thứ tự hiển thị (Nhỏ xếp trước)'),

                        Toggle::make('is_active')
                            ->default(true)
                            ->label('Trạng thái mở hiển thị'),
                    ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->disk('public')
                    ->height(60)
                    ->width(120)
                    ->label('Ảnh Banner'),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->label('Tiêu đề Slide'),

                TextColumn::make('subtitle')
                    ->searchable()
                    ->label('Phụ đề (Badge)'),

                TextColumn::make('sort_order')
                    ->sortable()
                    ->alignCenter()
                    ->label('Thứ tự'),

                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Đang hiển thị'),

                TextColumn::make('created_at')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Ngày tạo'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Trạng thái hiển thị'),
            ])
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
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
