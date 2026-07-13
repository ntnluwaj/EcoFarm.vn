<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Phiếu Xuất Kho - Đơn hàng #{{ $order->id }}</title>
    <style>
        body {
            font-family: "Courier New", Courier, monospace;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 20px;
            font-size: 13px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px dashed #000;
            padding-bottom: 15px;
        }
        .logo-title {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 1px;
            margin: 0 0 5px 0;
        }
        .doc-title {
            font-size: 16px;
            font-weight: bold;
            margin: 5px 0 0 0;
            text-transform: uppercase;
        }
        .info-section {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
        }
        .info-col {
            width: 48%;
        }
        .info-col p {
            margin: 4px 0;
        }
        .info-col strong {
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-row td {
            font-weight: bold;
            border-top: 2px solid #000;
        }
        .barcode {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin: 15px 0;
            letter-spacing: 6px;
            border: 1px solid #000;
            padding: 4px;
            display: inline-block;
        }
        .signatures {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            text-align: center;
        }
        .signature-box {
            width: 30%;
        }
        .signature-space {
            height: 60px;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
        .print-btn-container {
            text-align: right;
            margin-bottom: 15px;
        }
        .btn-print {
            background-color: #2e7d32;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="print-btn-container no-print">
        <button class="btn-print" onclick="window.print()">In phiếu xuất kho</button>
    </div>

    <div class="header">
        <h1 class="logo-title">ECOFARM VIETNAM</h1>
        <p style="margin: 0; font-size: 11px;">Địa chỉ kho: KCN Trà Nóc, Quận Bình Thủy, TP. Cần Thơ</p>
        <p style="margin: 3px 0 0 0; font-size: 11px;">Hotline: 1900 888 999 - Email: contact@ecofarm.vn</p>
        <h2 class="doc-title">PHIẾU XUẤT KHO & GIAO HÀNG VẬT TƯ</h2>
        <div class="barcode">|||| | | ||| |||| | |</div>
        <p style="margin: 0; font-size: 11px;">Mã vận đơn: DH{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }} | Ngày lập: {{ date('d/m/Y H:i') }}</p>
    </div>

    @php
        $rawAddress = $order->shipping_address;
        $cleanAddress = $rawAddress;
        $vatText = 'KHÔNG YÊU CẦU';
        
        if (str_contains($rawAddress, ' [Xuất HĐ: ')) {
            $parts = explode(' [Xuất HĐ: ', $rawAddress);
            $cleanAddress = $parts[0];
            $vatDetails = str_replace(']', '', $parts[1]);
            $vatText = "YÊU CẦU XUẤT HĐ ({$vatDetails})";
        }
    @endphp

    <div class="info-section">
        <div class="info-col">
            <h4 style="margin: 0 0 8px 0; border-bottom: 1px solid #000; padding-bottom: 4px; text-transform: uppercase;">Thông tin giao nhận</h4>
            <p>Khách hàng: <strong>{{ $order->customer_name }}</strong></p>
            <p>Điện thoại: <strong>{{ $order->customer_phone }}</strong></p>
            <p>Địa chỉ giao hàng: {{ $cleanAddress }}</p>
        </div>
        <div class="info-col">
            <h4 style="margin: 0 0 8px 0; border-bottom: 1px solid #000; padding-bottom: 4px; text-transform: uppercase;">Chi tiết chứng từ</h4>
            <p>Trạng thái đơn: <strong>{{ strtoupper($order->status) }}</strong></p>
            <p>Thanh toán: <strong>{{ strtoupper($order->payment_method) }}</strong></p>
            <p>VAT đỏ: {{ $vatText }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">STT</th>
                <th>Tên Mặt Hàng Vật Tư</th>
                <th class="text-center" style="width: 20%;">Quy Cách</th>
                <th class="text-center" style="width: 10%;">ĐVT</th>
                <th class="text-right" style="width: 10%;">SL</th>
                <th class="text-right" style="width: 15%;">Đơn Giá</th>
                <th class="text-right" style="width: 15%;">Thành Tiền</th>
            </tr>
        </thead>
        <tbody>
            @php $stt = 1; @endphp
            @foreach($order->items as $item)
                <tr>
                    <td class="text-center">{{ $stt++ }}</td>
                    <td>
                        {{ $item->product->name ?? 'Vật tư' }}
                        @if($item->productVariant)
                            <strong>({{ $item->productVariant->capacity }})</strong>
                        @endif
                    </td>
                    <td class="text-center">{{ $item->product->packaging ?? 'N/A' }}</td>
                    <td class="text-center">{{ $item->product->unit ?? 'Chai' }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->unit_price, 0, ',', '.') }}đ</td>
                    <td class="text-right">{{ number_format($item->quantity * $item->unit_price, 0, ',', '.') }}đ</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="4" class="text-right">TỔNG CỘNG HÓA ĐƠN:</td>
                <td class="text-right">{{ $order->items->sum('quantity') }}</td>
                <td></td>
                <td class="text-right">{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
            </tr>
        </tbody>
    </table>

    <div class="signatures">
        <div class="signature-box">
            <strong>Người Nhận Hàng</strong>
            <p style="font-size: 10px; font-style: italic; margin-top: 2px;">(Ký, ghi rõ họ tên)</p>
            <div class="signature-space"></div>
        </div>
        <div class="signature-box">
            <strong>Nhân Viên Đóng Gói</strong>
            <p style="font-size: 10px; font-style: italic; margin-top: 2px;">(Ký, xác nhận đóng gói)</p>
            <div class="signature-space"></div>
        </div>
        <div class="signature-box">
            <strong>Thủ Kho Xác Nhận</strong>
            <p style="font-size: 10px; font-style: italic; margin-top: 2px;">(Ký, đóng dấu xuất kho)</p>
            <div class="signature-space"></div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
