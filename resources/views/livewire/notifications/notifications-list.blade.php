<div>
    <div class="flex items-center justify-end mb-4">
        <button class="bg-red-500 px-4 py-2 text-sm text-white rounded-lg" wire:click="markAllRead">
            <x-heroicon-o-arrow-path wire:loading wire:target="markAllRead" class="h-6 w-6 text-white animate-spin"/>
            <span wire:loading.class="hidden" wire:target="markAllRead">Mark All Read</span>
        </button>
    </div>

    <div class="flex flex-col justify-center w-full grid grid-cols-1 gap-2">
        @foreach ($items as $notification) 
            @livewire('notifications.notifications-item', [
                'app' => $app,
                'item' => $notification
            ],key('notification-'.$notification->id))            
        @endforeach
    </div>

    @if($this->hasMorePages())
        @include('components.load-more')
    @endif
</div>
