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

    protected static ?string $pluralLabel = 'Liên hệ tư vấn';

    protected static ?string $modelLabel = 'Liên hệ';

    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Thông tin liên hệ từ khách hàng')
                    ->schema([
                        TextInput::make('name')
                            ->label('Họ và tên')
                            ->disabled(),
                        TextInput::make('phone')
                            ->label('Số điện thoại')
                            ->disabled(),
                        TextInput::make('email')
                            ->label('Email')
                            ->disabled()
                            ->placeholder('Không cung cấp'),
                        TextInput::make('subject')
                            ->label('Tiêu đề cần hỗ trợ')
                            ->disabled()
                            ->columnSpanFull(),
                        Textarea::make('message')
                            ->label('Nội dung cần hỗ trợ')
                            ->disabled()
                            ->columnSpanFull()
                            ->rows(4),
                    ])->columns(3),

                Section::make('Nội dung phản hồi của Kỹ sư Nông học')
                    ->schema([
                        Textarea::make('reply_content')
                            ->label('Nội dung phản hồi')
                            ->placeholder('Nhập nội dung tư vấn kỹ thuật hoặc phản hồi cho nhà vườn tại đây...')
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
                Tables\Actions\EditAction::make()->label('Phản hồi'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
