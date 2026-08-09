<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Models\Brand;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    
    protected static ?string $navigationLabel = 'Thương hiệu / Nhà SX';

    protected static ?string $navigationGroup = 'Danh mục & Sản phẩm';

    protected static ?int $navigationSort = 3;
    
    protected static ?string $modelLabel = 'Thương hiệu';
    
    protected static ?string $pluralModelLabel = 'Danh sách Thương hiệu';

    public static function canViewAny(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Section::make('THÔNG TIN THƯƠNG HIỆU / NHÀ SẢN XUẤT')
                    ->description('Nhập tên thương hiệu vật tư chính hãng và thông tin giới thiệu năng lực nhà sản xuất')
                    ->schema([
                        \Filament\Forms\Components\Grid::make(2)->schema([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(100)
                                ->placeholder('Ví dụ: Syngenta, Bayer, Phân Bón Đầu Trâu')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (string $operation, $state, $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null)
                                ->label('Tên thương hiệu vật tư *'),

                            TextInput::make('slug')
                                ->required()
                                ->maxLength(100)
                                ->unique(ignoreRecord: true)
                                ->label('Đường dẫn Slug (SEO tự động) *'),
                        ]),

                        Textarea::make('description')
                            ->nullable()
                            ->rows(3)
                            ->placeholder('Nhập lịch sử thương hiệu, chứng nhận ISO, quốc gia xuất xứ...')
                            ->columnSpanFull()
                            ->label('Thông tin giới thiệu nhà sản xuất'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->label('Mã ID'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Tên thương hiệu'),
                TextColumn::make('slug')
                    ->label('Mã định danh SEO'),
            ])
            ->filters([
                //
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

    public static function canDelete(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}