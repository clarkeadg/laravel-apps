<div class="tabs flex border border-gray-300 border-b-0">
    <x-nav-link href="{{ route($app.'.settings.profile') }}" :active="request()->routeIs($app.'.settings.profile')" class="py-2 px-6 text-center border-r border-b border-gray-300">
        Edit Profile
    </x-nav-link>
    <x-nav-link href="{{ route($app.'.members.show', Auth::user()->name) }}" :active="request()->routeIs($app.'.members.show')" class="py-2 px-6 text-center border-r border-b border-gray-300">
        View Your Profile
    </x-nav-link>
    <x-nav-link href="{{ route($app.'.settings.account') }}" :active="request()->routeIs($app.'.settings.account')" class="py-2 px-6 text-center border-r border-b border-gray-300">
        Account Settings
    </x-nav-link>
    <x-nav-link href="{{ route($app.'.settings.mail') }}" :active="request()->routeIs($app.'.settings.mail')" class="py-2 px-6 text-center border-r border-b border-gray-300">
        Mail Settings
    </x-nav-link>
    <x-nav-link href="{{ route($app.'.settings.photos') }}" :active="request()->routeIs($app.'.settings.photos')" class="py-2 px-6 text-center border-r border-b border-gray-300">
        Upload Photos
    </x-nav-link>
    <div class="flex grow border-b border-gray-300"></div>
</div>