<div>
    <x-nav-link href="{{ route($app.'.messages') }}" :active="request()->routeIs('pof.messages')">
        <div class="relative">
            <x-heroicon-o-envelope class="h-6 w-6 text-white dark:text-primary-400"/>
            @livewire('messenger.messages-count')
        </div>
    </x-nav-link>
</div>
