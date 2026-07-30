<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Định danh chính xác tên bảng trong MySQL theo mục 10 của tài liệu PRD
    protected $table = 'posts';

    // Khai báo các trường cho phép chèn dữ liệu hàng loạt
    protected $fillable = [
        'title',
        'slug',
        'content',
        'category',
        'thumbnail',
        'published_at',
    ];

    // Ép kiểu dữ liệu thời gian cho ngày xuất bản bài viết
    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function ($post) {
            if (is_null($post->published_at)) {
                $admins = \App\Models\User::where('role', 'admin')->get();
                foreach ($admins as $admin) {
                    \Filament\Notifications\Notification::make()
                        ->title('Bài viết mới chờ phê duyệt')
                        ->body("Bài viết \"{$post->title}\" vừa được tạo và đang chờ xuất bản.")
                        ->warning()
                        ->actions([
                            \Filament\Notifications\Actions\Action::make('view')
                                ->label('Duyệt ngay')
                                ->url(\App\Filament\Resources\PostResource::getUrl('edit', ['record' => $post]))
                                ->button(),
                        ])
                        ->sendToDatabase($admin);
                }
            }
        });
    }
}