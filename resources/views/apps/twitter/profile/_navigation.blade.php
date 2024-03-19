<div class="twitter-tabs flex mb-4">
    <x-nav-link href="{{ route($app.'.members.show', $profile->name) }}" :active="request()->routeIs($app.'.members.show')" class="grow py-2 px-6 text-center border-b-2 border-gray-300">
        Posts
    </x-nav-link>
    <x-nav-link href="{{ route($app.'.members.posts_replies', $profile->name) }}" :active="request()->routeIs($app.'.members.posts_replies')" class="grow py-2 px-6 text-center border-b-2 border-gray-300">
        Posts & Replies
    </x-nav-link>
    <x-nav-link href="{{ route($app.'.members.media', $profile->name) }}" :active="request()->routeIs($app.'.members.media')" class="grow py-2 px-6 text-center border-b-2 border-gray-300">
        Media
    </x-nav-link>
    @if($profile->is_my_profile)
        <x-nav-link href="{{ route($app.'.members.likes', $profile->name) }}" :active="request()->routeIs($app.'.members.likes')" class="grow py-2 px-6 text-center border-b-2 border-gray-300">
            Likes
        </x-nav-link>
    @endif
</div>