<div x-data="{ tab: 'chat' }" class="w-full">
    <div class="border border-gray-200 bg-white h-full w-full relative">
        <div class="tabs flex">
            <button @click="tab = 'chat'" :class="{ 'border-b-0': tab == 'chat' }" class="py-1 px-6 text-center border-r border-b border-gray-300">
                Chat
            </button>
            <button @click="tab = 'users'" :class="{ 'border-b-0': tab == 'users' }" class="py-1 px-6 text-center border-r border-b border-gray-300">
                Users
            </button>
            <div class="flex grow border-b border-gray-300"></div>
        </div>
        <div class="overflow-auto h-96 p-2">
            <div x-show="tab == 'chat'" x-cloak>
                @foreach ($messages as $item) 
                    <div class="text-sm">
                        <span class="font-bold">
                            {{ "@".$item['username'] }}
                        </span>
                        <span class="@if($item['type'] == 'status') italic @endif">
                            {{ $item['message'] }}
                        </span>
                    </div>
                @endforeach                        
            </div>
            <div x-show="tab == 'users'" x-cloak>
                @foreach ($users as $username) 
                    <div class="text-sm">
                        <span class="font-bold">
                            {{ "@".$username}}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="p-2">
            <form wire:submit="create">
                <div class="flex w-full items-center">
                    <div class="grow">
                        {{ $this->form }}
                    </div> 
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <x-heroicon-o-arrow-path wire:loading wire:target="create" class="h-6 w-6 mr-2 text-white animate-spin"/>
                        <span wire:loading.class="hidden" wire:target="create">Send</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
