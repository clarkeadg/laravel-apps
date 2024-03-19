<div>
    <div class="bg-white rounded-lg py-4">
        <div class="">
            <form wire:submit="create">
                {{ $this->form }}
                
                <div class="text-left pt-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <x-heroicon-o-arrow-path wire:loading class="h-6 w-6 mr-2 text-white animate-spin"/>
                        <span>Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
