<div> 
    @isset($object)
        @if($object_type == 'App\Models\Tweet')
            @livewire('tweets.tweet-item', [
                'app' => $app,
                'item' => $object,
                'hideFooter' => true
            ],key('report-tweet-'.$object->id)) 
        @endif
    @else
        @isset($profile)
            @include('apps.'.$app.'.cards.profile')
        @endisset
    @endisset

    <form wire:submit="create">
        <div class="py-4">
            {{ $this->form }}
        </div>

        <div class="flex w-full justify-between">
            <button wire:click="$dispatch('closeModal')" class="inline-flex px-4 py-2 rounded-full text-gray-500 bg-white border border-gray-500 hover:text-white hover:bg-black hover:border-white">
                Cancel
            </button>
            <button type="submit" class="inline-flex px-4 py-2 rounded-full text-white bg-red-500 hover:bg-red-400">
                <x-heroicon-o-arrow-path wire:loading class="h-6 w-6 mr-2 text-white animate-spin"/>
                <span>Report</span>
            </button>
        </div>
    </form>
</div>
