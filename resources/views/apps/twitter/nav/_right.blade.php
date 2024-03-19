<div class="py-2">
    @auth
        <nav class="nav-right flex flex-wrap items-center py-2 text-gray-400">            
            <x-nav-link href="{{ route($app.'.blocks') }}" :active="request()->routeIs($app.'.blocks')" class="flex items-center font-medium text-gray-400 hover:text-black focus:text-black">
                <span class="px-2">•</span>
                {{ __('Blocks') }}
            </x-nav-link>
            <x-nav-link href="{{ route($app.'.mutes') }}" :active="request()->routeIs($app.'.mutes')" class="flex items-center font-medium text-gray-400 hover:text-black focus:text-black">
                <span class="px-2">•</span>
                {{ __('Mutes') }}
            </x-nav-link>
        </nav>
    @endauth

    @livewire('tags.tags-trending', [
        'app' => $app,
        'object_type' => 'App\Models\Tweet',
    ])
</div>
