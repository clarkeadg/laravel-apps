<div class="twitter-tabs flex bg-white border border-gray-300 rounded-t-lg">
    <x-nav-link href="{{ route($app.'.messages') }}" :active="request()->routeIs($app.'.messages')" class="grow py-2 px-6 text-center border-b-2 border-gray-300">
        Messages
    </x-nav-link>
    <x-nav-link href="{{ route($app.'.messages.sent') }}" :active="request()->routeIs($app.'.messages.sent')" class="grow py-2 px-6 text-center border-b-2 border-gray-300">
        Sent
    </x-nav-link>
</div>