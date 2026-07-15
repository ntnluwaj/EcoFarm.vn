<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\AIChatLog;

class AIAdvisorController extends Controller
{
    /**
     * TRỢ LÝ AI ECOBOT TƯ VẤN KỸ THUẬT NÔNG NGHIỆP
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = $request->message;
        $sessionId = session()->getId();
        $userId = Auth::id();

        // 1. Phân tích Topic & Sentiment sơ bộ (NLP cơ bản bằng PHP)
        $messageLower = mb_strtolower($message, 'UTF-8');
        $topic = 'Tư vấn chung';
        $sentiment = 'neutral';

        // Phân tích Topic
        if (str_contains($messageLower, 'rỉ sắt') || str_contains($messageLower, 'rỉ sét') || str_contains($messageLower, 'nấm') || str_contains($messageLower, 'sầu riêng')) {
            $topic = 'Bệnh hại sầu riêng';
        } elseif (str_contains($messageLower, 'npk') || str_contains($messageLower, 'bình điền') || str_contains($messageLower, 'đầu trâu')) {
            $topic = 'Kỹ thuật phân bón NPK';
        } elseif (str_contains($messageLower, 'ure') || str_contains($messageLower, 'phú mỹ') || str_contains($messageLower, 'đạm')) {
            $topic = 'Đạm Ure Phú Mỹ';
        } elseif (str_contains($messageLower, 'sâu') || str_contains($messageLower, 'rầy') || str_contains($messageLower, 'regent') || str_contains($messageLower, 'cuốn lá')) {
            $topic = 'Phòng trừ sâu hại';
        }

        // Phân tích Sentiment
        if (str_contains($messageLower, 'buồn') || str_contains($messageLower, 'hại') || str_contains($messageLower, 'chết') || str_contains($messageLower, 'bệnh') || str_contains($messageLower, 'sâu') || str_contains($messageLower, 'héo')) {
            $sentiment = 'negative';
        } elseif (str_contains($messageLower, 'cảm ơn') || str_contains($messageLower, 'tốt') || str_contains($messageLower, 'hay') || str_contains($messageLower, 'giúp')) {
            $sentiment = 'positive';
        }

        $apiKey = env('GEMINI_API_KEY');
        $responseContent = "";

        // 2. Gọi API Google Gemini nếu có khóa API
        if (!empty($apiKey)) {
            try {
                $sysInstruction = "Bạn là EcoBot, một kỹ sư nông nghiệp kiêm trợ lý ảo nông nghiệp thông minh của trang web EcoFarm.vn. Nhiệm vụ của bạn là tư vấn kỹ thuật trồng trọt, cách bón phân NPK, Ure, hoặc phòng trừ dịch hại (bệnh rỉ sắt trên sầu riêng, sâu cuốn lá, rầy nâu hại lúa). Hãy trả lời ngắn gọn, thiết thực, có thiện chí giúp đỡ bà con bằng tiếng Việt. Khi giới thiệu giải pháp điều trị, bắt buộc phải gợi ý các sản phẩm có bán tại EcoFarm và định dạng đường dẫn sản phẩm chính xác dưới dạng markdown như sau để nông dân click mua được luôn:
- Thuốc trừ bệnh Anvil 5SC: [Anvil 5SC Syngenta](/san-pham/thuoc-tru-benh-anvil-5sc-syngenta)
- Thuốc trừ sâu Regent: [Regent 800WG Bayer](/san-pham/thuoc-tru-sau-regent-800wg-bayer)
- Phân bón Ure Phú Mỹ: [Phân bón Ure Phú Mỹ hạt trong](/san-pham/phan-bon-ure-phu-my-hat-trong)
- Phân bón NPK Đầu Trâu: [Phân NPK Đầu Trâu 20-20-15](/san-pham/phan-bon-npk-dau-trau-20-20-15-cao-cap)
Không được tự chế các liên kết khác.";

                $apiResponse = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [
                                ['text' => "System Instruction: {$sysInstruction}\n\nUser Message: {$message}"]
                            ]
                        ]
                    ]
                ]);

                if ($apiResponse->successful()) {
                    $json = $apiResponse->json();
                    $responseContent = $json['candidates'][0]['content']['parts'][0]['text'] ?? '';
                } else {
                    Log::error("Gemini API call failed: " . $apiResponse->body());
                }
            } catch (\Exception $e) {
                Log::error("Gemini API Exception: " . $e->getMessage());
            }
        }

        // 3. Fallback: Hệ thống chuyên gia dựa trên luật (Rule-based Expert System) nếu không có API key hoặc lỗi
        if (empty($responseContent)) {
            if ($topic === 'Bệnh hại sầu riêng') {
                $responseContent = "Chào bà con! Đối với bệnh nấm rỉ sắt hại sầu riêng mùa mưa dầm, bà con cần chú ý cắt tỉa cành thông thoáng, dọn cỏ gốc để giảm ẩm độ. Về mặt thuốc BVTV, bà con hãy phun ngay thuốc trừ nấm nội hấp cực mạnh **[Anvil 5SC Syngenta](/san-pham/thuoc-tru-benh-anvil-5sc-syngenta)** định kỳ 7-10 ngày/lần khi bệnh chớm xuất hiện để tiêu diệt mầm bệnh và phục hồi lá xanh.";
            } elseif ($topic === 'Kỹ thuật phân bón NPK') {
                $responseContent = "Chào bà con! Việc bón thúc NPK giúp lúa đẻ nhánh tối đa và kích thích cây trồng phát triển rễ tốt. Khuyến nghị bà con sử dụng **[Phân NPK Đầu Trâu 20-20-15](/san-pham/phan-bon-npk-dau-trau-20-20-15-cao-cap)** với hàm lượng dinh dưỡng cân đối Đa - Trung - Vi lượng, bón thúc gốc với liều lượng 150-250kg/ha.";
            } elseif ($topic === 'Đạm Ure Phú Mỹ') {
                $responseContent = "Chào bà con! Phân đạm giúp lá xanh mướt và đẩy nhanh tốc độ đẻ nhánh của lúa. Bà con nên bón phân đạm chất lượng cao là **[Phân bón Ure Phú Mỹ hạt trong](/san-pham/phan-bon-ure-phu-my-hat-trong)** cho lúa và rau màu với liều lượng bón lót hoặc bón thúc từ 100-150kg/ha.";
            } elseif ($topic === 'Phòng trừ sâu hại') {
                $responseContent = "Chào bà con! Rầy nâu truyền bệnh lúa và sâu cuốn lá là dịch hại nghiêm trọng đầu vụ. Để bảo vệ cây lúa, bà con hãy sử dụng thuốc trừ sâu phổ rộng cực mạnh **[Regent 800WG Bayer](/san-pham/thuoc-tru-sau-regent-800wg-bayer)** của Bayer. Hãy pha 1 gói 1.6g cho bình 16 - 25 Lít nước phun ướt đều tán lá.";
            } else {
                $responseContent = "Chào bà con! Tôi là **EcoBot - Trợ lý ảo nông nghiệp AI** của EcoFarm.vn. Tôi có chuyên môn tư vấn cách bón phân NPK/Ure, trị bệnh rỉ sắt trên cây sầu riêng hoặc diệt sâu cuốn lá, rầy nâu hại lúa. Để xử lý hiệu quả nhất, bà con có thể tham khảo các sản phẩm chính hãng của chúng tôi như **[Anvil 5SC Syngenta](/san-pham/thuoc-tru-benh-anvil-5sc-syngenta)** hoặc **[Regent 800WG Bayer](/san-pham/thuoc-tru-sau-regent-800wg-bayer)**.";
            }
        }

        // 4. Lưu nhật ký chat vào CSDL phục vụ phân tích dữ liệu ở Dashboard DSS
        try {
            AIChatLog::create([
                'user_id' => $userId,
                'session_id' => $sessionId,
                'message' => $message,
                'response' => $responseContent,
                'detected_topic' => $topic,
                'sentiment' => $sentiment,
            ]);
        } catch (\Exception $e) {
            Log::error("Lỗi ghi nhật ký chat AI: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'response' => $responseContent,
        ]);
    }
}
