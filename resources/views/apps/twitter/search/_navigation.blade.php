<div class="twitter-tabs flex mb-4">
    <x-nav-link href="{{ route($app.'.search') }}" :active="request()->routeIs($app.'.search')" class="grow py-2 px-6 text-center border-b-2 border-gray-300">
        Users
    </x-nav-link>
    <x-nav-link href="{{ route($app.'.search.tweets') }}" :active="request()->routeIs($app.'.search.tweets')" class="grow py-2 px-6 text-center border-b-2 border-gray-300">
        Tweets
    </x-nav-link>
    <x-nav-link href="{{ route($app.'.search.hashtags') }}" :active="request()->routeIs($app.'.search.hashtags')" class="grow py-2 px-6 text-center border-b-2 border-gray-300">
        Hashtags
    </x-nav-link>
</div>