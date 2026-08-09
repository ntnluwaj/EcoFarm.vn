<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationLabel = 'Liên hệ tư vấn';

    protected static ?string $navigationGroup = 'Khách hàng & Tư vấn';

    protected static ?string $pluralLabel = 'Liên hệ tư vấn';

    protected static ?string $modelLabel = 'Liên hệ';

    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'engineer']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('THÔNG TIN YÊU CẦU TƯ VẤN TỪ NHÀ VƯỜN')
                    ->description('Chi tiết thông tin liên hệ và nội dung cần tư vấn hỗ trợ kỹ thuật của bà con')
                    ->schema([
                        TextInput::make('name')
                            ->label('Họ và tên nhà vườn')
                            ->disabled(),
                        TextInput::make('phone')
                            ->label('Số điện thoại liên hệ')
                            ->disabled(),
                        TextInput::make('email')
                            ->label('Địa chỉ Email')
                            ->disabled()
                            ->placeholder('Không cung cấp'),
                        TextInput::make('subject')
                            ->label('Tiêu đề thắc mắc kỹ thuật')
                            ->disabled()
                            ->columnSpanFull(),
                        Textarea::make('message')
                            ->label('Nội dung mô tả thắc mắc của nhà vườn')
                            ->disabled()
                            ->columnSpanFull()
                            ->rows(4),
                    ])->columns(3),

                Section::make('NỘI DUNG PHẢN HỒI KỸ THUẬT NÔNG HỌC')
                    ->description('Nhập nội dung tư vấn kỹ thuật bón tưới hoặc phản hồi giải pháp cho nhà vườn')
                    ->schema([
                        Textarea::make('reply_content')
                            ->label('Nội dung phản hồi kỹ thuật *')
                            ->placeholder('Nhập chi tiết liều lượng, giải pháp tư vấn kỹ thuật nông học tại đây...')
                            ->required()
                            ->columnSpanFull()
                            ->rows(5),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Mã LH')
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Khách hàng')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Điện thoại')
                    ->searchable(),
                TextColumn::make('subject')
                    ->label('Tiêu đề liên hệ')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('status')
                    ->label('Trạng thái')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'replied' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Chờ phản hồi',
                        'replied' => 'Đã phản hồi',
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Ngày gửi')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Trạng thái')
                    ->options([
                        'pending' => 'Chờ phản hồi',
                        'replied' => 'Đã phản hồi',
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()->label('Phản hồi kỹ thuật')->color('primary'),
                    Tables\Actions\DeleteAction::make()->color('danger'),
                ])
                ->label('Thao tác')
                ->icon('heroicon-m-ellipsis-horizontal')
                ->color('gray')
                ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListContacts::route('/'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
