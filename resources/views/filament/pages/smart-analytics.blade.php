<x-filament-panels::page>
    <!-- Nhúng thư viện Chart.js qua CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div x-data="{ activeTab: 'forecasting' }" class="space-y-6">
        <!-- Hệ thống tab điều hướng mượt mà với AlpineJS -->
        <div class="flex border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 rounded-t-xl px-4 shadow-sm">
            <button @click="activeTab = 'forecasting'" 
                :class="activeTab === 'forecasting' ? 'border-emerald-600 text-emerald-600 dark:text-emerald-400 font-bold border-b-2' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" 
                class="py-4 px-6 text-sm focus:outline-none transition duration-150 flex items-center gap-2">
                <span class="text-lg">📈</span> Dự báo doanh số (SES & Regression)
            </button>
            <button @click="activeTab = 'rfm'" 
                :class="activeTab === 'rfm' ? 'border-emerald-600 text-emerald-600 dark:text-emerald-400 font-bold border-b-2' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" 
                class="py-4 px-6 text-sm focus:outline-none transition duration-150 flex items-center gap-2">
                <span class="text-lg">👥</span> Phân khúc RFM (CRM thông minh)
            </button>
            <button @click="activeTab = 'inventory'" 
                :class="activeTab === 'inventory' ? 'border-emerald-600 text-emerald-600 dark:text-emerald-400 font-bold border-b-2' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" 
                class="py-4 px-6 text-sm focus:outline-none transition duration-150 flex items-center gap-2">
                <span class="text-lg">📦</span> Quản lý tồn kho tối ưu (Safety Stock & ROP)
            </button>
        </div>

        <!-- 🌟 TAB 1: DỰ BÁO DOANH SỐ -->
        <div x-show="activeTab === 'forecasting'" class="space-y-6" x-transition>
            <!-- Thẻ tóm tắt học thuật -->
            <div class="bg-gradient-to-r from-emerald-800 to-teal-700 text-white rounded-xl p-6 shadow-md">
                <h3 class="text-lg font-bold mb-2 flex items-center gap-2">🔬 Nghiên cứu khoa học dữ liệu kinh doanh</h3>
                <p class="text-sm text-emerald-100 leading-relaxed max-w-4xl">
                    Hệ thống áp dụng hai phương pháp thống kê học thuật tiêu chuẩn:
                    <strong>Single Exponential Smoothing (San bằng mũ đơn - SES)</strong> với hệ số san bằng tự thích ứng $\alpha = 0.3$ giúp loại bỏ nhiễu và làm phẳng dao động ngắn hạn;
                    và <strong>Hồi quy tuyến tính đơn giản (SLR)</strong> giúp phân tích xu hướng tăng trưởng dài hạn của thị trường vật tư nông nghiệp miền Tây.
                </p>
            </div>

            <!-- Grid biểu đồ và công thức -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Biểu đồ -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-900 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-800">
                    <h4 class="text-sm font-bold text-gray-700 dark:text-gray-200 mb-4">Biểu đồ đối chiếu doanh số thực tế và dự báo tương lai</h4>
                    <div style="height: 320px; position: relative;">
                        <canvas id="forecastChart"></canvas>
                    </div>
                </div>

                <!-- Diễn giải công thức toán học -->
                <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-800 flex flex-col justify-between">
                    <div>
                        <h4 class="text-sm font-bold text-gray-700 dark:text-gray-200 mb-3">Mô hình toán học ứng dụng</h4>
                        <div class="space-y-4 text-xs text-gray-600 dark:text-gray-400">
                            <div>
                                <p class="font-bold text-emerald-600 dark:text-emerald-400">1. San bằng mũ đơn (SES):</p>
                                <p class="italic bg-gray-50 dark:bg-gray-800 p-2 rounded mt-1 text-center font-mono">
                                    F_{t+1} = &alpha; \cdot Y_t + (1 - &alpha;) \cdot F_t
                                </p>
                                <p class="mt-1">Dự báo kỳ tiếp theo bằng tổng trọng số của doanh số thực tế kỳ trước và dự báo kỳ trước.</p>
                            </div>
                            <div>
                                <p class="font-bold text-emerald-600 dark:text-emerald-400">2. Hồi quy tuyến tính (SLR):</p>
                                <p class="italic bg-gray-50 dark:bg-gray-800 p-2 rounded mt-1 text-center font-mono">
                                    Y = a + b \cdot X
                                </p>
                                <p class="mt-1">Tìm đường xu hướng tuyến tính đi qua dữ liệu thực tế bằng phương pháp bình phương bé nhất (Ordinary Least Squares).</p>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-100 dark:border-gray-800 text-xs text-gray-500">
                        * Dữ liệu được tính toán động dựa trên các vận đơn giao dịch thành công.
                    </div>
                </div>
            </div>

            <!-- Bảng chi tiết số liệu -->
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                    <h4 class="text-sm font-bold text-gray-700 dark:text-gray-200">Bảng đối chiếu thống kê chi tiết</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 font-semibold border-b border-gray-100 dark:border-gray-800">
                                <th class="p-4">Kỳ phân tích / Dự báo</th>
                                <th class="p-4">Doanh số Thực tế ($Y_t$)</th>
                                <th class="p-4">San bằng mũ đơn ($F_t$)</th>
                                <th class="p-4">Đường xu hướng hồi quy</th>
                                <th class="p-4">Trạng thái dữ liệu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-700 dark:text-gray-300">
                            <!-- Hiển thị 6 tháng lịch sử -->
                            @foreach($forecastingData['months'] as $index => $month)
                                <tr>
                                    <td class="p-4 font-bold">{{ $month }}</td>
                                    <td class="p-4 font-semibold text-emerald-600 dark:text-emerald-400">
                                        {{ number_format($forecastingData['actual'][$index], 0, ',', '.') }}đ
                                    </td>
                                    <td class="p-4 text-gray-500">
                                        {{ number_format($forecastingData['ses'][$index], 0, ',', '.') }}đ
                                    </td>
                                    <td class="p-4 text-gray-500">
                                        {{ number_format($forecastingData['regression'][$index], 0, ',', '.') }}đ
                                    </td>
                                    <td class="p-4">
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-2xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200">
                                            <span class="h-1.5 w-1.5 rounded-circle bg-gray-400"></span> Dữ liệu lịch sử
                                        </span>
                                    </td>
                                </tr>
                            @endforeach

                            <!-- Hiển thị 3 tháng tương lai -->
                            @foreach($forecastingData['future_months'] as $index => $month)
                                <tr class="bg-emerald-50/20 dark:bg-emerald-950/10">
                                    <td class="p-4 font-bold text-emerald-700 dark:text-emerald-300">{{ $month }}</td>
                                    <td class="p-4 text-gray-400 italic">Chưa phát sinh (Đang dự báo)</td>
                                    <td class="p-4 text-emerald-600 dark:text-emerald-400 font-semibold">
                                        {{ number_format($forecastingData['future_ses'][$index], 0, ',', '.') }}đ
                                    </td>
                                    <td class="p-4 text-teal-600 dark:text-teal-400 font-semibold">
                                        {{ number_format($forecastingData['future_reg'][$index], 0, ',', '.') }}đ
                                    </td>
                                    <td class="p-4">
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-2xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                            <span class="h-1.5 w-1.5 rounded-circle bg-emerald-500 animate-pulse"></span> Dự báo tương lai
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 🌟 TAB 2: PHÂN KHÚC KHÁCH HÀNG RFM -->
        <div x-show="activeTab === 'rfm'" class="space-y-6" x-transition>
            <!-- Tóm tắt RFM -->
            <div class="bg-gradient-to-r from-teal-800 to-indigo-800 text-white rounded-xl p-6 shadow-md">
                <h3 class="text-lg font-bold mb-2 flex items-center gap-2">📊 Mô hình phân khúc khách hàng RFM (Recency - Frequency - Monetary)</h3>
                <p class="text-sm text-teal-100 leading-relaxed max-w-4xl">
                    RFM là mô hình khoa học dữ liệu kinh doanh được chấp nhận rộng rãi để định vị khách hàng dựa trên 3 hành vi giao dịch chính:
                    <strong>Recency (Độ gần đây)</strong> - Số ngày kể từ đơn hàng cuối cùng;
                    <strong>Frequency (Tần suất)</strong> - Tổng số đơn đặt hàng;
                    và <strong>Monetary (Giá trị tiền)</strong> - Tổng doanh thu đóng góp. 
                    Thuật toán tự động chấm điểm mỗi chiều từ 1-5 và phân bổ khách hàng vào các nhóm hành vi cụ thể để đại lý ra quyết định khuyến mãi tối ưu.
                </p>
            </div>

            <!-- Tổng hợp phân khúc -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                @foreach($rfmSegments['summary'] as $key => $seg)
                    <div class="bg-white dark:bg-gray-900 rounded-xl p-4 shadow-sm border border-gray-100 dark:border-gray-800 flex flex-col justify-between">
                        <div>
                            <span class="inline-flex px-2 py-0.5 rounded-md text-2xs font-bold bg-{{ $seg['color'] }}-100 text-{{ $seg['color'] }}-800 dark:bg-{{ $seg['color'] }}-900/30 dark:text-{{ $seg['color'] }}-300">
                                {{ $seg['label'] }}
                            </span>
                            <p class="text-2xs text-gray-500 mt-2 leading-tight">{{ $seg['desc'] }}</p>
                        </div>
                        <div class="mt-4 pt-2 border-t border-gray-50 dark:border-gray-800">
                            <span class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $seg['count'] }}</span>
                            <span class="text-2xs text-gray-400">khách hàng</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Chi tiết phân khúc khách hàng -->
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                    <h4 class="text-sm font-bold text-gray-700 dark:text-gray-200">Danh sách xếp hạng phân khúc khách hàng động</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 font-semibold border-b border-gray-100 dark:border-gray-800">
                                <th class="p-4">Khách hàng</th>
                                <th class="p-4">Số điện thoại</th>
                                <th class="p-4">Giao dịch cuối (R)</th>
                                <th class="p-4">Số đơn mua (F)</th>
                                <th class="p-4">Tổng chi tiêu (M)</th>
                                <th class="p-4">Điểm hành vi (R-F-M)</th>
                                <th class="p-4">Phân khúc</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-700 dark:text-gray-300">
                            @foreach($rfmSegments['details'] as $cust)
                                <tr>
                                    <td class="p-4 font-bold">{{ $cust['name'] }}<br><span class="text-3xs text-gray-400">{{ $cust['email'] }}</span></td>
                                    <td class="p-4 text-gray-600 dark:text-gray-400">{{ $cust['phone'] }}</td>
                                    <td class="p-4 text-gray-600 dark:text-gray-400">{{ $cust['recency'] }}</td>
                                    <td class="p-4 text-gray-600 dark:text-gray-400">{{ $cust['frequency'] }}</td>
                                    <td class="p-4 font-semibold text-gray-800 dark:text-gray-200">{{ $cust['monetary'] }}</td>
                                    <td class="p-4 font-mono font-bold text-blue-600 dark:text-blue-400">{{ $cust['score'] }}</td>
                                    <td class="p-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-3xs font-medium bg-{{ $cust['color'] }}-100 text-{{ $cust['color'] }}-800 dark:bg-{{ $cust['color'] }}-900/30 dark:text-{{ $cust['color'] }}-300">
                                            {{ $cust['segment'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 🌟 TAB 3: TỐI ƯU HÓA KHO BÃI (ROP & SAFETY STOCK) -->
        <div x-show="activeTab === 'inventory'" class="space-y-6" x-transition>
            <!-- Tóm tắt ROP -->
            <div class="bg-gradient-to-r from-sky-800 to-cyan-700 text-white rounded-xl p-6 shadow-md">
                <h3 class="text-lg font-bold mb-2 flex items-center gap-2">📦 Chuỗi cung ứng thông minh: Safety Stock & Reorder Point (ROP)</h3>
                <p class="text-sm text-sky-100 leading-relaxed max-w-4xl">
                    Để tránh tình trạng đứt gãy chuỗi cung ứng vật tư nông nghiệp (cháy hàng khi mùa vụ cao điểm) hoặc ứ đọng vốn (tồn kho quá nhiều), hệ thống tính toán động 
                    <strong>Điểm tái đặt hàng (Reorder Point - ROP)</strong> và <strong>Lượng tồn kho an toàn (Safety Stock - SS)</strong> cho từng sản phẩm dựa trên doanh số bán thực tế hàng ngày trong 60 ngày gần nhất.
                </p>
            </div>

            <!-- Minh họa công thức -->
            <div class="bg-white dark:bg-gray-900 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-800">
                <h4 class="text-sm font-bold text-gray-700 dark:text-gray-200 mb-3">Công thức chuỗi cung ứng ứng dụng</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs text-gray-600 dark:text-gray-400">
                    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                        <p class="font-bold text-sky-600 dark:text-sky-400 mb-1">1. Lượng tồn an toàn (Safety Stock - SS):</p>
                        <p class="font-mono bg-white dark:bg-gray-900 p-2 rounded text-center my-1">SS = 1.5 \cdot d \cdot L</p>
                        <p class="mt-1">Giúp hấp thụ các dao động đột biến về nhu cầu hoặc sự chậm trễ trong khâu giao nhận vật tư từ nhà sản xuất.</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                        <p class="font-bold text-sky-600 dark:text-sky-400 mb-1">2. Điểm tái đặt hàng (Reorder Point - ROP):</p>
                        <p class="font-mono bg-white dark:bg-gray-900 p-2 rounded text-center my-1">ROP = (d \cdot L) + SS</p>
                        <p class="mt-1">Khi lượng tồn kho thực tế giảm xuống mức ROP, hệ thống cảnh báo quản kho tạo vận đơn nhập bổ sung ngay lập tức.</p>
                    </div>
                </div>
                <div class="mt-3 text-3xs text-gray-400">
                    * Trong đó: $d$ là nhu cầu tiêu thụ trung bình ngày; $L$ là Lead Time (Thời gian gom hàng từ nhà sản xuất, cố định mặc định = 3 ngày).
                </div>
            </div>

            <!-- Bảng sức khỏe kho hàng -->
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                    <h4 class="text-sm font-bold text-gray-700 dark:text-gray-200">Báo cáo tình trạng sức khỏe tồn kho sản phẩm động</h4>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300 font-semibold border-b border-gray-100 dark:border-gray-800">
                                <th class="p-4">Tên Sản phẩm vật tư</th>
                                <th class="p-4 text-center">Tồn thực tế</th>
                                <th class="p-4 text-center">Tiêu thụ ngày ($d$)</th>
                                <th class="p-4 text-center">Tồn an toàn ($SS$)</th>
                                <th class="p-4 text-center">Điểm tái đặt hàng ($ROP$)</th>
                                <th class="p-4">Tình trạng kho</th>
                                <th class="p-4">Khuyến nghị hành động</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-700 dark:text-gray-300">
                            @foreach($inventoryHealth as $item)
                                <tr>
                                    <td class="p-4 font-bold">{{ $item['name'] }}</td>
                                    <td class="p-4 text-center font-bold text-gray-800 dark:text-gray-100">{{ $item['stock'] }} {{ $item['unit'] }}</td>
                                    <td class="p-4 text-center font-semibold text-gray-600 dark:text-gray-400">{{ $item['daily_demand'] }} / ngày</td>
                                    <td class="p-4 text-center text-gray-500">{{ $item['safety_stock'] }} {{ $item['unit'] }}</td>
                                    <td class="p-4 text-center font-bold text-blue-600 dark:text-blue-400">{{ $item['rop'] }} {{ $item['unit'] }}</td>
                                    <td class="p-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-3xs font-medium bg-{{ $item['color'] }}-100 text-{{ $item['color'] }}-800 dark:bg-{{ $item['color'] }}-900/30 dark:text-{{ $item['color'] }}-300">
                                            {{ $item['status'] }}
                                        </span>
                                    </td>
                                    <td class="p-4 font-medium text-{{ $item['color'] }}-800 dark:text-{{ $item['color'] }}-300 text-2xs">{{ $item['recommendation'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Khởi tạo dữ liệu đồ thị ChartJS cho tab Dự báo -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Lấy dữ liệu từ backend PHP biên dịch sang JSON
            const months = @json($forecastingData['months']);
            const actual = @json($forecastingData['actual']);
            const ses = @json($forecastingData['ses']);
            const regression = @json($forecastingData['regression']);
            
            const futureMonths = @json($forecastingData['future_months']);
            const futureSes = @json($forecastingData['future_ses']);
            const futureReg = @json($forecastingData['future_reg']);

            // Hợp nhất nhãn thời gian
            const allLabels = [...months, ...futureMonths];

            // Hợp nhất dữ liệu hiển thị (Thực tế chỉ có trong 6 tháng lịch sử, tương lai là null)
            const allActual = [...actual, null, null, null];
            
            // SES: nối tiếp dữ liệu lịch sử và dự báo
            const allSes = [...ses, ...futureSes];

            // Hồi quy: nối tiếp dữ liệu lịch sử và dự báo
            const allReg = [...regression, ...futureReg];

            const ctx = document.getElementById('forecastChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: allLabels,
                    datasets: [
                        {
                            label: 'Doanh số Thực tế (Lịch sử)',
                            data: allActual,
                            borderColor: '#10b981', // Emerald
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            borderWidth: 3,
                            pointRadius: 5,
                            pointBackgroundColor: '#10b981',
                            fill: true,
                            tension: 0.15
                        },
                        {
                            label: 'Dự báo San bằng mũ đơn (SES)',
                            data: allSes,
                            borderColor: '#f59e0b', // Amber
                            borderDash: [5, 5],
                            borderWidth: 2.5,
                            pointRadius: 4,
                            pointBackgroundColor: '#f59e0b',
                            fill: false,
                            tension: 0.1
                        },
                        {
                            label: 'Xu hướng Hồi quy tuyến tính (SLR)',
                            data: allReg,
                            borderColor: '#06b6d4', // Cyan
                            borderWidth: 2,
                            pointRadius: 0,
                            fill: false,
                            tension: 0
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                boxWidth: 15,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            ticks: {
                                font: {
                                    size: 10
                                },
                                callback: function(value) {
                                    return (value / 1000000).toFixed(0) + 'M';
                                }
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 10
                                }
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-filament-panels::page>
