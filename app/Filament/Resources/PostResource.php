<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Cẩm nang & Tin tức';

    protected static ?string $modelLabel = 'Bài viết';

    protected static ?string $pluralModelLabel = 'Danh sách bài viết';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Nội dung bài viết')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null)
                            ->label('Tiêu đề cẩm nang'),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->label('Đường dẫn Slug (SEO)'),

                        RichEditor::make('content')
                            ->required()
                            ->columnSpanFull()
                            ->label('Nội dung cẩm nang'),
                    ])->columnSpan(2),

                Section::make('Thông tin xuất bản & Kiểm duyệt')
                    ->schema([
                        Select::make('category')
                            ->options([
                                'Kỹ thuật canh tác' => 'Kỹ thuật canh tác',
                                'Lịch mùa vụ' => 'Lịch mùa vụ',
                                'Tin thị trường' => 'Tin thị trường',
                            ])
                            ->required()
                            ->label('Chuyên mục bài viết'),

                        FileUpload::make('thumbnail')
                            ->image()
                            ->directory('posts')
                            ->disk('public')
                            ->label('Ảnh đại diện bài viết'),

                        DateTimePicker::make('published_at')
                            ->placeholder('Nhấp chọn để phê duyệt xuất bản')
                            ->label('Thời gian xuất bản công khai'),
                    ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->disk('public')
                    ->square()
                    ->label('Ảnh'),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->label('Tiêu đề cẩm nang'),

                TextColumn::make('category')
                    ->badge()
                    ->colors([
                        'success' => 'Kỹ thuật canh tác',
                        'warning' => 'Lịch mùa vụ',
                        'info' => 'Tin thị trường',
                    ])
                    ->label('Chuyên mục'),

                TextColumn::make('published_at')
                    ->dateTime('H:i - d/m/Y')
                    ->sortable()
                    ->placeholder('Bản nháp (Chưa duyệt)')
                    ->label('Ngày xuất bản'),

                TextColumn::make('created_at')
                    ->dateTime('H:i - d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Ngày tạo'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'Kỹ thuật canh tác' => 'Kỹ thuật canh tác',
                        'Lịch mùa vụ' => 'Lịch mùa vụ',
                        'Tin thị trường' => 'Tin thị trường',
                    ])
                    ->label('Lọc theo chuyên mục'),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
