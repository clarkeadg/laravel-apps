<div class="absolute -top-2 -right-3">
    @if($count > 0)
        <div class="w-6 h-6 font-bold text-white text-xs rounded-full bg-red-400 flex items-center justify-center">
            {{ number_format($count) }}
        </div>
    @endif
</div>
