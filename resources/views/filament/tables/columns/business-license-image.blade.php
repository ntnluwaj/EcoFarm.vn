<div class="px-4 py-2">
    @if($getState())
        <a href="{{ asset($getState()) }}" target="_blank">
            <img src="{{ asset($getState()) }}" 
                 alt="Giấy phép KD" 
                 class="rounded shadow-sm border" 
                 style="max-width: 80px; height: auto; max-height: 50px; object-fit: cover;">
        </a>
    @else
        <span class="text-muted text-xs">Không có ảnh</span>
    @endif
</div>