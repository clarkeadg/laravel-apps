<div x-data="{ open: false }" class="relative">
    <button x-on:click="open = true" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out">
        <div class="relative">
            <x-heroicon-o-bell class="h-6 w-6"/>
            @livewire('notifications.notifications-count')
        </div>
    </button>

    <div x-cloak x-show.transition="open" x-on:click.away="open = false" class="z-50 absolute right-0 w-60 mt-2 bg-white border rounded shadow-xl">   
        <div class="flex flex-col justify-center w-full">
            @foreach ($items as $notification) 
                @livewire('notifications.notifications-item', [
                    'app' => $app,
                    'item' => $notification,
                    'size' => 'small'
                ],key('notification-button-'.$notification->id)) 
            @endforeach
        </div>

        <x-nav-link href="{{ route($app.'.notifications') }}" class="mt-1 flex w-full justify-center items-center transition-colors duration-200 block px-4 py-2 text-normal text-gray-900 rounded hover:bg-blue-500 hover:text-white">
            View All
        </x-nav-link>
    </div>
</div>
