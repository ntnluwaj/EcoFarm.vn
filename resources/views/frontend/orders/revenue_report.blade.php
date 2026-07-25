<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Báo Cáo Doanh Thu & Vận Đơn - EcoFarm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 20px;
            font-size: 13px;
        }
        .header {
            text-align: center;
            border-bottom: 2px double #000;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #555;
        }
        .meta-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 12px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }
        .summary-box {
            border: 1px solid #ccc;
            padding: 12px;
            border-radius: 4px;
            text-align: center;
            background-color: #fafafa;
        }
        .summary-box .title {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .summary-box .value {
            font-size: 16px;
            font-weight: bold;
        }
        .summary-box .value.revenue {
            color: #c62828;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .details-table th, .details-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .details-table th {
            background-color: #f1f1f1;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            text-align: center;
            font-size: 12px;
        }
        .signature-box {
            width: 200px;
        }
        .signature-space {
            height: 70px;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Báo Cáo Doanh Thu & Vận Đơn EcoFarm</h1>
        <p>Hệ thống cung ứng vật tư nông nghiệp & Kỹ thuật canh tác miền Tây</p>
    </div>

    <div class="meta-info">
        <div>
            <strong>Ngày lập báo cáo:</strong> {{ date('d/m/Y H:i:s') }}<br>
            <strong>Người lập:</strong> Ban Quản trị EcoFarm ({{ auth()->user()->name }})
        </div>
        <div class="text-right">
            <strong>Mẫu báo cáo:</strong> BC-DT-01<br>
            <strong>Chu kỳ:</strong> Toàn thời gian
        </div>
    </div>

    <div class="summary-grid">
        <div class="summary-box">
            <div class="title">Tổng số đơn hàng</div>
            <div class="value">{{ $totalOrders }}</div>
        </div>
        <div class="summary-box">
            <div class="title">Tổng doanh thu</div>
            <div class="value revenue">{{ number_format($totalRevenue, 0, ',', '.') }}đ</div>
        </div>
        <div class="summary-box">
            <div class="title">Đã thu tiền</div>
            <div class="value" style="color: #2e7d32;">{{ number_format($paidRevenue, 0, ',', '.') }}đ</div>
        </div>
        <div class="summary-box">
            <div class="title">Chưa thu (Giao COD)</div>
            <div class="value" style="color: #e65100;">{{ number_format($unpaidRevenue, 0, ',', '.') }}đ</div>
        </div>
    </div>

    <div class="summary-grid" style="margin-top: -10px;">
        <div class="summary-box">
            <div class="title">Thanh toán VietQR</div>
            <div class="value" style="font-size: 14px;">{{ $vietqrCount }} đơn</div>
        </div>
        <div class="summary-box">
            <div class="title">Thanh toán COD</div>
            <div class="value" style="font-size: 14px;">{{ $codCount }} đơn</div>
        </div>
        <div class="summary-box">
            <div class="title">Hoàn tất / Đang giao</div>
            <div class="value" style="font-size: 14px;">{{ $completedCount }} / {{ $shippingCount }} đơn</div>
        </div>
        <div class="summary-box">
            <div class="title">Chờ duyệt / Đã hủy</div>
            <div class="value" style="font-size: 14px;">{{ $pendingCount }} / {{ $cancelledCount }} đơn</div>
        </div>
    </div>

    <h2 style="font-size: 15px; border-bottom: 1px solid #000; padding-bottom: 5px; margin-top: 30px;">Danh sách chi tiết vận đơn</h2>
    
    <table class="details-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 100px;">Mã đơn</th>
                <th style="width: 130px;">Ngày đặt</th>
                <th>Khách hàng</th>
                <th style="width: 100px;">Điện thoại</th>
                <th class="text-right" style="width: 120px;">Doanh thu</th>
                <th class="text-center" style="width: 110px;">Phương thức</th>
                <th class="text-center" style="width: 110px;">Thanh toán</th>
                <th class="text-center" style="width: 110px;">Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $o)
                <tr>
                    <td class="text-center" style="font-weight: bold;">ECF{{ str_pad($o->id, 6, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $o->created_at ? $o->created_at->format('d/m/Y H:i') : '' }}</td>
                    <td>{{ $o->customer_name }}</td>
                    <td>{{ $o->customer_phone }}</td>
                    <td class="text-right fw-bold">{{ number_format($o->total_amount, 0, ',', '.') }}đ</td>
                    <td class="text-center">{{ strtoupper($o->payment_method) }}</td>
                    <td class="text-center">
                        {{ $o->payment_status === 'paid' ? 'Đã thu' : 'Chưa thu' }}
                    </td>
                    <td class="text-center">
                        @switch($o->status)
                            @case('pending') Chờ duyệt @break
                            @case('processing') Đang gói @break
                            @case('shipping') Đang giao @break
                            @case('completed') Hoàn tất @break
                            @case('cancelled') Đã hủy @break
                            @default {{ $o->status }}
                        @endswitch
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-box">
            <p><strong>Người lập báo cáo</strong></p>
            <p class="signature-space"></p>
            <p style="text-decoration: underline;">{{ auth()->user()->name }}</p>
        </div>
        <div class="signature-box">
            <p><strong>Xác nhận Giám đốc kho</strong></p>
            <p class="signature-space"></p>
            <p style="font-style: italic; color: #888;">(Ký và ghi rõ họ tên)</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
