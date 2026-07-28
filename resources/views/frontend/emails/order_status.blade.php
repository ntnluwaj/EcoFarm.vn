<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f9fa;
            color: #333333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .header {
            background-color: #2e7d32;
            color: #ffffff;
            padding: 24px;
            text-align: center;
        }
        .header h2 {
            margin: 0 0 5px 0;
            font-size: 22px;
        }
        .header p {
            margin: 0;
            opacity: 0.9;
            font-size: 14px;
        }
        .content {
            padding: 24px;
        }
        .status-banner {
            padding: 15px;
            border-radius: 6px;
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 16px;
        }
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-processing { background-color: #d1ecf1; color: #0c5460; }
        .status-shipping { background-color: #cce5ff; color: #004085; }
        .status-completed { background-color: #d4edda; color: #155724; }
        .status-cancelled { background-color: #f8d7da; color: #721c24; }
        
        .section-title {
            font-size: 15px;
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 2px solid #e9ecef;
            color: #2e7d32;
        }
        .info-table, .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 13.5px;
        }
        .info-table td {
            padding: 6px 0;
        }
        .info-table td.label {
            color: #6c757d;
            width: 130px;
        }
        .info-table td.val {
            font-weight: bold;
        }
        .item-table th, .item-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        .item-table th {
            background-color: #f8f9fa;
            color: #495057;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .total-amount {
            font-size: 18px;
            color: #d9534f;
            font-weight: bold;
        }
        .btn-track {
            display: block;
            width: 200px;
            margin: 25px auto 10px auto;
            padding: 12px 20px;
            background-color: #2e7d32;
            color: #ffffff;
            text-decoration: none;
            text-align: center;
            font-weight: bold;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .footer {
            background-color: #f1f3f4;
            padding: 20px;
            text-align: center;
            font-size: 11px;
            color: #6c757d;
            border-top: 1px solid #e9ecef;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>EcoFarm.vn - Vận Đơn Nông Nghiệp</h2>
        <p>Hệ thống cung ứng vật tư & Kỹ thuật canh tác miền Tây</p>
    </div>
    
    <div class="content">
        <p>Kính chào <strong>{{ $order->customer_name }}</strong>,</p>
        <p>Chúng tôi xin thông báo trạng thái vận đơn của bà con đã được cập nhật trên hệ thống quản lý kho.</p>

        @php
            $formattedId = 'ECF' . str_pad($order->id, 6, '0', STR_PAD_LEFT);
            $statusText = match($order->status) {
                'pending' => 'CHỜ XÁC NHẬN / DUYỆT ĐƠN',
                'processing' => 'ĐANG ĐÓNG GÓI & BỐC XẾP VẬT TƯ',
                'shipping' => 'ĐANG TRÊN XE TẢI GIAO VẬN CHUYỂN',
                'completed' => 'HOÀN TẤT GIAO NHẬN & THANH TOÁN',
                'cancelled' => 'ĐƠN HÀNG ĐÃ BỊ HỦY',
                default => strtoupper($order->status)
            };
        @endphp

        <div class="status-banner status-{{ $order->status }}">
            {{ $statusText }}
        </div>

        <div class="section-title">Thông tin giao nhận vật tư</div>
        <table class="info-table">
            <tr>
                <td class="label">Mã vận đơn:</td>
                <td class="val">{{ $formattedId }}</td>
            </tr>
            <tr>
                <td class="label">Người nhận hàng:</td>
                <td class="val">{{ $order->customer_name }}</td>
            </tr>
            <tr>
                <td class="label">Số điện thoại:</td>
                <td class="val">{{ $order->customer_phone }}</td>
            </tr>
            <tr>
                <td class="label">Địa chỉ giao:</td>
                <td class="val">{{ $order->shipping_address }}</td>
            </tr>
            <tr>
                <td class="label">Thanh toán:</td>
                <td class="val">
                    {{ strtoupper($order->payment_method) }} 
                    ({{ $order->payment_status === 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán / Giao COD' }})
                </td>
            </tr>
        </table>

        <div class="section-title">Chi tiết sản phẩm đặt mua</div>
        <table class="item-table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th class="text-right">SL</th>
                    <th class="text-right">Đơn giá</th>
                    <th class="text-right">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>
                            {{ $item->product->name ?? 'Sản phẩm' }}
                            @if($item->productVariant)
                                <br><small style="color: #6c757d;">Quy cách: {{ $item->productVariant->name }}</small>
                            @endif
                        </td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">{{ number_format($item->price, 0, ',', '.') }}đ</td>
                        <td class="text-right">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-right" style="font-weight: bold;">Tổng cộng:</td>
                    <td class="text-right total-amount">{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                </tr>
            </tbody>
        </table>

        <a href="{{ route('orders.track', ['order_id' => $order->id, 'phone' => $order->customer_phone]) }}" class="btn-track" style="color: #ffffff;">
            🚚 Theo dõi lịch trình trực tuyến
        </a>
        
        <p style="font-size: 12px; color: #6c757d; text-align: center; margin-top: 15px;">
            Nếu cần tư vấn kỹ thuật trực tiếp, vui lòng gọi điện hotline: 0398 037 435.
        </p>
    </div>
    
    <div class="footer">
        <p>Bản quyền © {{ date('Y') }} EcoFarm Vietnam. Mọi quyền được bảo lưu.</p>
        <p>Địa chỉ kho tổng: Khu công nghiệp Trà Nóc, Quận Bình Thủy, TP. Cần Thơ.</p>
    </div>
</div>

</body>
</html>
