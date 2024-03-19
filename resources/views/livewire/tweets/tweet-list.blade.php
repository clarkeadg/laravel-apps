<div>
    @isset($title)
        <div class="flex w-full items-center mb-4">
            @isset($icon)
                @svg('heroicon-o-'.$icon, 'h-6 w-6 mr-2')
            @endisset
            <div class="font-bold text-lg">{{ $title }}</div>
        </div>
    @endisset

    @if($name == "search")
        <div class="mb-4">
            <form wire:submit="create">
                <div class="flex w-full items-center">
                    <div class="grow">
                        {{ $this->form }}
                    </div> 
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <x-heroicon-o-arrow-path wire:loading wire:target="create" class="h-6 w-6 mr-2 text-white animate-spin"/>
                        <span wire:loading.class="hidden" wire:target="create">Search</span>
                    </button>
                </div>
            </form>
        </div>

        @isset($username)
            <div class="mb-4 text-gray-500 text-center">
                *You are searching for tweets from <a class="font-bold hover:underline" href="{{ '/@'.$username }}">{{ "@".$username }}</a>                
            </div>
        @endisset
    @endif

    @isset($items)
        <div class="w-full grid grid-cols-1 gap-2 mb-5">
            @foreach ($items as $tweet)   
                @livewire('tweets.tweet-item', [
                    'app' => $app,
                    'item' => $tweet
                ],key('tweet-'.$tweet->id))    
            @endforeach
        </div>
    @endisset

    @if($this->hasMorePages())
        @include('components.load-more')
    @endif
</div>
