<div>
    @isset($thread)
        <div class="flex flex-col justify-center w-full grid grid-cols-1 gap-2">
            @foreach ($thread->messages as $message) 
            <div class="flex w-full items-center mb-2 bg-white border-l border-gray-200 overflow-hidden relative">
                <a class="image-hover w-32 text-center" href="{{ route($app.'.members.show', $message->user->name) }}">
                    <img src="{{ $message->user->avatar_thumb }}" alt="{{ $message->user->name }}" class="">
                    <h5 class="text-blue-400">{{ $message->user->name }}</h5>
                </a>
                <div class="w-full px-4">        
                    <p>{{ $message->body }}</p>
                    <div class="text-muted absolute top-2 right-4">
                        <small>Posted {{ $message->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($recipient->blocked_me)
            <div class="p-4 text-center">
                You have been blocked.
            </div>
        @else
            <div class="">
                <form wire:submit="create">
                    {{ $this->form }}
                    
                    <div class="text-left pt-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <x-heroicon-o-arrow-path wire:loading class="h-6 w-6 mr-2 text-white animate-spin"/>
                            <span wire:loading.class="hidden">Post Message</span>
                        </button>
                    </div>
                </form>
            </div>
        @endif

    @endisset
</div>
