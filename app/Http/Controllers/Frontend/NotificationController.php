<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * CHI TIẾT THÔNG BÁO VÀ ĐÁNH DẤU ĐÃ ĐỌC
     */
    public function show($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        
        // Đánh dấu thông báo này là đã đọc
        $notification->markAsRead();
        
        $data = $notification->data;
        
        return view('frontend.notifications.show', compact('notification', 'data'));
    }

    /**
     * ĐÁNH DẤU CHƯA ĐỌC LẠI (MARK AS UNREAD)
     */
    public function markAsUnread($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->read_at = null;
        $notification->save();
        
        return redirect()->route('home')->with('success', 'Đã đánh dấu thông báo là chưa đọc.');
    }
}
