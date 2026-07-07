<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:15',
            'email' => 'nullable|email|max:100',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
        ], [
            'name.required' => 'Họ và tên là bắt buộc.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'subject.required' => 'Tiêu đề liên hệ là bắt buộc.',
            'message.required' => 'Nội dung liên hệ là bắt buộc.',
        ]);

        $contact = Contact::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        // Gửi thông báo đến trang quản trị Filament Admin
        try {
            $admins = \App\Models\User::where('role', 'admin')->get();
            \Filament\Notifications\Notification::make()
                ->title('Có yêu cầu liên hệ mới!')
                ->body("Nông dân {$request->name} vừa gửi yêu cầu tư vấn: '{$request->subject}'")
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color('info')
                ->sendToDatabase($admins);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Lỗi khi gửi thông báo liên hệ Filament: " . $e->getMessage());
        }

        // Gửi cảnh báo Telegram hỏa tốc
        try {
            $telegramMessage = "✉️ *YÊU CẦU LIÊN HỆ MỚI - ECOFARM*\n";
            $telegramMessage .= "───────────────────────\n";
            $telegramMessage .= "👤 *Họ tên:* {$request->name}\n";
            $telegramMessage .= "📞 *Điện thoại:* `{$request->phone}`\n";
            $telegramMessage .= "✉️ *Email:* {$request->email}\n";
            $telegramMessage .= "📝 *Tiêu đề:* _{$request->subject}_\n";
            $telegramMessage .= "💬 *Nội dung:* {$request->message}\n";
            $telegramMessage .= "───────────────────────";

            \Illuminate\Support\Facades\Log::info("EcoFarm Telegram Alert Fallback Log: Contact request '{$request->subject}' from {$request->name} created.");

            $botToken = env('TELEGRAM_BOT_TOKEN');
            $chatId = env('TELEGRAM_CHAT_ID');
            if ($botToken && $chatId) {
                $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
                $client = new \GuzzleHttp\Client();
                $client->post($url, [
                    'json' => [
                        'chat_id' => $chatId,
                        'text' => $telegramMessage,
                        'parse_mode' => 'Markdown',
                    ]
                ]);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Lỗi gửi Telegram liên hệ: " . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Gửi thông tin liên hệ thành công! Kỹ sư nông học sẽ phản hồi lại cho bà con sớm nhất.');
    }
}
