<div>
    @isset($recipient)
        <div class="mb-4">        
            <a href="{{ route($app.'.members.show', $recipient->name) }}" class="image-hover">
                <div class="w-full lg:flex">
                    <!-- Image -->    
                    <div class="w-full lg:w-32 flex-none text-center overflow-hidden img-container">
                        <img class="w-full" src="{{ $recipient->avatar_thumb }}" alt="" />
                    </div>
                    <!-- Info --> 
                    <div class="w-full p-4 lg:p-0 lg:pl-4 flex flex-col items-center justify-center lg:items-start leading-normal">
                        <div class="text-blue-400 font-bold text-lg truncate">
                            {{ $recipient->name }}
                        </div>
                    </div>
                </div>
            </a>        
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
                            <span wire:loading.class="hidden">Create Message</span>
                        </button>
                    </div>
                </form>
            </div>
        @endif
    @endisset
</div>
