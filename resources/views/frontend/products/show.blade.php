@extends('frontend.layouts.master')

@section('title', $product->name . ' - Vật Tư Nông Nghiệp')

@section('og_title', $product->name . ' - Vật Tư Nông Nghiệp EcoFarm')
@section('og_image', is_array($product->images) && count($product->images) > 0 ? asset('storage/' . $product->images[0]) : (!empty($product->image) ? asset('storage/' . $product->image) : asset('images/logo.png')))
@section('og_description', strip_tags(str($product->description)->limit(160)))
@section('meta_description', strip_tags(str($product->description)->limit(160)))

@section('content')
<div class="container py-4" style="min-height: 80vh;">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white p-3 rounded-3 shadow-sm small mb-0">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-success text-decoration-none">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-success text-decoration-none">Sản phẩm vật tư</a></li>
            <li class="breadcrumb-item active text-muted" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4 mb-5">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 d-flex flex-column justify-content-center" style="min-height: 420px; height: 100%;">
                
                @php
                    // Do đã cast array trong Model nên $product->images đã là mảng PHP thuần
                    $gallery = is_array($product->images) ? $product->images : [];
                @endphp

                @if(count($gallery) > 0)
                    <div id="productImagesCarousel" class="carousel slide carousel-dark" data-bs-ride="carousel">
                        <div class="carousel-indicators mb-0">
                            @foreach($gallery as $index => $img)
                                <button type="button" data-bs-target="#productImagesCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></button>
                            @endforeach
                        </div>

                        <div class="carousel-inner rounded-3">
                            @foreach($gallery as $index => $img)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }} text-center p-4">
                                    <img src="{{ asset('storage/' . $img) }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 300px; object-fit: contain;">
                                </div>
                            @endforeach
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#productImagesCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </</button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productImagesCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    </div>
                @elseif(!empty($product->image))
                    <div class="text-center p-4">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded-3" style="max-height: 300px; object-fit: contain;">
                    </div>
                @else
                    <div class="text-center text-muted p-4">
                        <i class="fa-solid fa-prescription-bottle-medical text-success-subtle mb-3" style="font-size: 80px;"></i>
                        <p class="fw-bold mb-0 text-uppercase small text-secondary">Sản phẩm phân phối chính hãng</p>
                    </div>
                @endif

            </div>
        </div>

        <div class="col-md-7">
            <div class="card border-0 shadow-sm p-4 bg-white rounded-4 h-100 d-flex flex-column justify-content-between">
                <div>
                    <span class="badge bg-success mb-2 px-2.5 py-1.5 text-uppercase fw-semibold" style="font-size: 11px;">
                        {{ $product->category->name ?? 'Vật tư nông nghiệp EcoFarm' }}
                    </span>
                    <h2 class="fw-bold text-dark mb-1 fs-3">{{ $product->name }}</h2>
                    <p class="small text-muted mb-4">Nhà sản xuất: <span class="text-success fw-semibold">{{ $product->brand->name ?? 'Chính hãng cung ứng' }}</span></p>

                    <div class="card bg-light border-0 p-4 rounded-3 mb-4">
                        <span class="text-muted small d-block mb-1 fw-medium">
                            <i class="fa-solid fa-tags me-1 text-success"></i> Giá bán lẻ niêm yết công khai:
                        </span>
                        <span id="display-price" class="text-success fw-bold fs-2">{{ number_format($product->price, 0, ',', '.') }} VND</span>
                    </div>

                    <div class="row g-3 mb-4 small text-dark">
                        <div class="col-6">
                            <div class="p-2.5 bg-light rounded-3 d-flex align-items-center">
                                <i class="fa-solid fa-scale-balanced text-success fs-5 me-3" style="width: 24px;"></i>
                                <div>
                                    <span class="text-muted d-block text-xs">Đơn vị cơ sở</span>
                                    <strong class="text-dark">{{ $product->unit }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2.5 bg-light rounded-3 d-flex align-items-center">
                                <i class="fa-solid fa-box text-success fs-5 me-3" style="width: 24px;"></i>
                                <div>
                                    <span class="text-muted d-block text-xs">Quy cách đóng gói</span>
                                    <strong class="text-dark">{{ $product->packaging }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($product->variants->count() > 0)
                        <div class="mb-4">
                            <label class="form-label text-muted small fw-bold text-uppercase d-block mb-2">Chọn dung tích / trọng lượng:</label>
                            <div class="d-flex flex-wrap gap-2" id="variant-selector">
                                @foreach($product->variants as $var)
                                    <button type="button" class="btn btn-outline-success btn-sm px-3 py-2 rounded-3 fw-bold variant-btn" data-id="{{ $var->id }}" data-price="{{ $var->price }}" data-stock="{{ $var->stock }}" data-capacity="{{ $var->capacity }}">
                                        {{ $var->capacity }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <form action="{{ route('cart.add', $product->slug) }}" method="POST" class="mt-2">
                    @csrf
                    <input type="hidden" name="variant_id" id="selected-variant-id" value="">

                    <div class="row g-2 align-items-center" id="buy-buttons-row">
                        @if($product->stock > 0)
                            <div class="col-3 col-lg-2" id="quantity-col">
                                <input type="number" name="quantity" id="quantity-input" class="form-control form-control-lg text-center fw-bold border-2" value="1" min="1" max="{{ $product->stock }}" style="height: 48px;">
                            </div>
                            <div class="col-9 col-lg-5">
                                <button type="submit" name="action" value="add_to_cart" class="btn btn-outline-success btn-lg w-100 fw-bold d-flex align-items-center justify-content-center gap-2 fs-6" style="height: 48px;">
                                    <i class="fa-solid fa-cart-plus"></i> Đưa vào giỏ hàng
                                </button>
                            </div>
                            <div class="col-12 col-lg-5">
                                <button type="submit" name="action" value="buy_now" class="btn btn-success btn-lg w-100 fw-bold d-flex align-items-center justify-content-center gap-2 fs-6 shadow-sm" style="height: 48px; background-color: #1b5e20; border: none;">
                                    <i class="fa-solid fa-bolt"></i> Mua ngay & Thanh toán
                                </button>
                            </div>
                        @else
                            <div class="col-12">
                                <button type="button" class="btn btn-secondary btn-lg w-100 fw-bold d-flex align-items-center justify-content-center gap-2" style="height: 48px;" disabled>
                                    <i class="fa-solid fa-circle-xmark"></i> Tạm hết hàng / Chờ nhập thêm kho bãi
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Nút Nhờ Kỹ Sư Tư Vấn (Đặt ngoài buy-buttons-row để tránh bị JS ghi đè khi đổi biến thể) -->
                    <div class="mt-3">
                        <button type="button" class="btn btn-warning btn-lg w-100 fw-bold d-flex align-items-center justify-content-center gap-2 fs-6 text-white" style="height: 48px; background-color: #ff9800; border: none; color: #ffffff !important;" data-bs-toggle="modal" data-bs-target="#adviceModal" data-message="Tôi cần tư vấn gấp về sản phẩm '{{ $product->name }}' trước khi đặt mua. Xin cảm ơn!">
                            <i class="fa-solid fa-user-doctor"></i> Nhờ Kỹ sư tư vấn trước khi mua
                        </button>
                    </div>

                    <div class="mt-2 text-xs" id="stock-label">
                        @if($product->stock > 0)
                            <span class="text-success fw-bold"><i class="fa-solid fa-circle-check"></i> Còn hàng</span>
                        @else
                            <span class="text-danger fw-bold"><i class="fa-solid fa-circle-xmark"></i> Tạm hết hàng</span>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
        <div class="bg-light p-2 border-bottom">
            <ul class="nav nav-pills" id="productTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold text-xs" id="info-tab" data-bs-toggle="tab" data-bs-target="#info-content" type="button" role="tab">
                        <i class="fa-solid fa-flask-vial me-2"></i>Công dụng & Hoạt chất
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold text-xs ms-2 text-secondary" id="safety-tab" data-bs-toggle="tab" data-bs-target="#safety-content" type="button" role="tab">
                        <i class="fa-solid fa-shield-heart me-2"></i>Hướng dẫn bón tưới an toàn
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold text-xs ms-2 text-secondary" id="review-tab" data-bs-toggle="tab" data-bs-target="#review-content" type="button" role="tab">
                        <i class="fa-solid fa-star me-2"></i>Đánh giá & Hỏi đáp kỹ thuật
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body p-4 text-dark" style="line-height: 1.7; font-size: 14px;">
            <div class="tab-content" id="productTabContent">
                <div class="tab-pane fade show active" id="info-content" role="tabpanel">
                    {!! $product->description !!}
                </div>
                <div class="tab-pane fade" id="safety-content" role="tabpanel">
                    {!! $product->usage_guide !!}
                </div>
                <div class="tab-pane fade" id="review-content" role="tabpanel">
                    <div class="row g-4">
                        <!-- Cột Trái: Đánh giá & Phản hồi (Reviews) -->
                        <div class="col-md-6 border-end pe-md-4">
                            <h5 class="fw-bold text-success mb-3"><i class="fa-solid fa-comments me-2"></i>Đánh giá từ nhà vườn</h5>
                            
                            @if($reviews->count() > 0)
                                <div class="mb-4">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span class="fs-1 fw-bold text-dark">{{ number_format($reviews->avg('rating'), 1) }}</span>
                                        <div>
                                            <div class="text-warning">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fa-{{ $i <= round($reviews->avg('rating')) ? 'solid' : 'regular' }} fa-star"></i>
                                                @endfor
                                            </div>
                                            <span class="text-muted text-xs">Dựa trên {{ $reviews->count() }} lượt đánh giá</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex flex-column gap-3 mb-4" style="max-height: 400px; overflow-y: auto;">
                                    @foreach($reviews as $rev)
                                        <div class="p-3 bg-light rounded-3 border">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <strong class="text-dark small">{{ $rev->reviewer_name }}</strong>
                                                <span class="text-muted text-xs">{{ $rev->created_at->format('d/m/Y') }}</span>
                                            </div>
                                            <div class="text-warning text-xs mb-1.5">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fa-{{ $i <= $rev->rating ? 'solid' : 'regular' }} fa-star"></i>
                                                @endfor
                                            </div>
                                            <p class="mb-0 text-secondary small">{{ $rev->comment }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center text-muted py-4 small mb-3">
                                    <i class="fa-regular fa-comment-dots fs-3 mb-2 d-block"></i>
                                    Chưa có đánh giá nào cho sản phẩm này. Hãy là người đầu tiên đánh giá!
                                </div>
                            @endif

                            <!-- Form gửi đánh giá -->
                            <div class="bg-light p-3 rounded-3 border">
                                <h6 class="fw-bold text-dark mb-3">Gửi đánh giá của bạn</h6>
                                <form action="{{ route('products.storeReview', $product->slug) }}" method="POST">
                                    @csrf
                                    <div class="mb-2.5">
                                        <label class="form-label text-muted small mb-1">Họ tên của bạn:</label>
                                        <input type="text" name="reviewer_name" class="form-control form-control-sm rounded-2" placeholder="Ví dụ: Anh Ba Trà Vinh" value="{{ auth()->check() ? auth()->user()->name : '' }}">
                                    </div>
                                    <div class="mb-2.5">
                                        <label class="form-label text-muted small mb-1">Điểm đánh giá (Chọn số sao):</label>
                                        <select name="rating" class="form-select form-select-sm rounded-2" required>
                                            <option value="5">⭐⭐⭐⭐⭐ (5/5 sao - Rất tốt)</option>
                                            <option value="4">⭐⭐⭐⭐ (4/5 sao - Tốt)</option>
                                            <option value="3">⭐⭐⭐ (3/5 sao - Bình thường)</option>
                                            <option value="2">⭐⭐ (2/5 sao - Tạm được)</option>
                                            <option value="1">⭐ (1/5 sao - Kém)</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted small mb-1">Nhận xét thực tế:</label>
                                        <textarea name="comment" rows="3" class="form-control form-control-sm rounded-2" placeholder="Chia sẻ kinh nghiệm sử dụng vật tư nông nghiệp này cho bà con..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-sm w-100 fw-bold rounded-2">Gửi nhận xét đánh giá</button>
                                </form>
                            </div>
                        </div>

                        <!-- Cột Phải: Hỏi đáp Kỹ thuật (Q&A) -->
                        <div class="col-md-6 ps-md-4">
                            <h5 class="fw-bold text-success mb-3"><i class="fa-solid fa-graduation-cap me-2"></i>Hỏi đáp kỹ sư nông học</h5>

                            @if($questions->count() > 0)
                                <div class="d-flex flex-column gap-3 mb-4" style="max-height: 400px; overflow-y: auto;">
                                    @foreach($questions as $q)
                                        <div class="p-3 bg-light rounded-3 border">
                                            <div class="mb-2">
                                                <span class="badge bg-secondary text-xs mb-1">{{ $q->asker_name }}</span>
                                                <p class="mb-0 fw-semibold text-dark small"><i class="fa-solid fa-circle-question text-warning me-1.5"></i>{{ $q->question }}</p>
                                            </div>
                                            <div class="p-2.5 bg-success-subtle rounded-2 border border-success-subtle text-dark">
                                                <p class="mb-1 text-xs text-success-emphasis fw-bold"><i class="fa-solid fa-user-doctor me-1"></i>Trả lời từ Kỹ sư EcoFarm:</p>
                                                <p class="mb-0 text-secondary text-xs" style="line-height: 1.5;">{{ $q->answer }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center text-muted py-4 small mb-3">
                                    <i class="fa-solid fa-chalkboard-user fs-3 mb-2 d-block"></i>
                                    Chưa có câu hỏi kỹ thuật nào được giải đáp.
                                </div>
                            @endif

                            <!-- Form gửi câu hỏi -->
                            <div class="bg-light p-3 rounded-3 border">
                                <h6 class="fw-bold text-dark mb-3">Đặt câu hỏi kỹ thuật canh tác</h6>
                                <form action="{{ route('products.storeQuestion', $product->slug) }}" method="POST">
                                    @csrf
                                    <div class="mb-2.5">
                                        <label class="form-label text-muted small mb-1">Họ tên của bạn:</label>
                                        <input type="text" name="asker_name" class="form-control form-control-sm rounded-2" placeholder="Ví dụ: Út Lúa Đồng Tháp" value="{{ auth()->check() ? auth()->user()->name : '' }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted small mb-1">Câu hỏi về liều lượng bón/tưới, cách kết hợp bảo vệ thực vật:</label>
                                        <textarea name="question" rows="4" class="form-control form-control-sm rounded-2" placeholder="Ví dụ: Phân NPK này dùng bón thúc cho sầu riêng giai đoạn nuôi trái nhỏ tỉ lệ bao nhiêu và kết hợp phun vi lượng nào?" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-sm w-100 fw-bold rounded-2">Gửi câu hỏi cho Kỹ sư</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const variantButtons = document.querySelectorAll('.variant-btn');
        const priceDisplay = document.getElementById('display-price');
        const variantIdInput = document.getElementById('selected-variant-id');
        const quantityInput = document.getElementById('quantity-input');
        const quantityCol = document.getElementById('quantity-col');
        const buyButtonsRow = document.getElementById('buy-buttons-row');
        const stockLabel = document.getElementById('stock-label');
        
        function selectVariant(button) {
            variantButtons.forEach(btn => {
                btn.classList.remove('btn-success', 'text-white');
                btn.classList.add('btn-outline-success');
            });
            
            button.classList.add('btn-success', 'text-white');
            button.classList.remove('btn-outline-success');
            
            const variantId = button.getAttribute('data-id');
            const price = parseFloat(button.getAttribute('data-price'));
            const stock = parseInt(button.getAttribute('data-stock'));
            
            variantIdInput.value = variantId;
            priceDisplay.textContent = new Intl.NumberFormat('vi-VN').format(price) + ' VND';
            
            if (stock > 0) {
                stockLabel.innerHTML = `<span class="text-success fw-bold"><i class="fa-solid fa-circle-check"></i> Còn hàng</span>`;
                if (quantityInput) {
                    quantityInput.max = stock;
                    quantityInput.value = 1;
                }
                if (quantityCol) {
                    quantityCol.style.display = 'block';
                }
                
                buyButtonsRow.innerHTML = `
                    <div class="col-3 col-lg-2" id="quantity-col">
                        <input type="number" name="quantity" id="quantity-input" class="form-control form-control-lg text-center fw-bold border-2" value="1" min="1" max="${stock}" style="height: 48px;">
                    </div>
                    <div class="col-9 col-lg-5">
                        <button type="submit" name="action" value="add_to_cart" class="btn btn-outline-success btn-lg w-100 fw-bold d-flex align-items-center justify-content-center gap-2 fs-6" style="height: 48px;">
                            <i class="fa-solid fa-cart-plus"></i> Đưa vào giỏ hàng
                        </button>
                    </div>
                    <div class="col-12 col-lg-5">
                        <button type="submit" name="action" value="buy_now" class="btn btn-success btn-lg w-100 fw-bold d-flex align-items-center justify-content-center gap-2 fs-6 shadow-sm" style="height: 48px; background-color: #1b5e20; border: none;">
                            <i class="fa-solid fa-bolt"></i> Mua ngay & Thanh toán
                        </button>
                    </div>
                `;
            } else {
                stockLabel.innerHTML = `<span class="text-danger fw-bold"><i class="fa-solid fa-circle-xmark"></i> Tạm hết hàng</span>`;
                buyButtonsRow.innerHTML = `
                    <div class="col-12">
                        <button type="button" class="btn btn-secondary btn-lg w-100 fw-bold d-flex align-items-center justify-content-center gap-2" style="height: 48px;" disabled>
                            <i class="fa-solid fa-circle-xmark"></i> Tạm hết hàng / Chờ nhập thêm kho bãi
                        </button>
                    </div>
                `;
            }
        }
        
        if (variantButtons.length > 0) {
            variantButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    selectVariant(this);
                });
            });
            selectVariant(variantButtons[0]);
        }
    });
</script>

<style>
    .nav-pills .nav-link.active { background-color: #2e7d32 !important; color: #fff !important; }
    .nav-pills .nav-link:not(.active):hover { background-color: #e8f5e9; color: #2e7d32 !important; }
    .text-xs { font-size: 13px !important; }
</style>
@endsection