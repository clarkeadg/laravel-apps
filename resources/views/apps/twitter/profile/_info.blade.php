<div class="pl-5">
    <h2 class="font-semibold text-lg text-blue-400 leading-tight flex items-center">
        {{ $profile->twitter_display_name }}
        @livewire('user.user-online', ['userId' => $profile->id])
    </h2>
    <p class="text-gray-500">
        {{ "@".$profile->name }}
    </p>
    <div class="flex gap-4 items-center py-1 mb-1">
        <a href="{{ route($app.'.members.followers', $profile->name) }}" class="text-gray-500 hover:text-black hover:underline font-medium">
            {{ number_format($profile->followers_count) }} Followers
        </a>
        <a href="{{ route($app.'.members.following', $profile->name) }}" class="text-gray-500 hover:text-black hover:underline font-medium">
            {{ number_format($profile->following_count) }} Following
        </a>
    </div>
    @isset($profile->twitter_bio)
        <p class="text-gray-500 mb-3">
            {{ $profile->twitter_bio }}
        </p>
    @endisset
    <div class="flex items-center text-gray-500">
        <x-heroicon-o-calendar class="h-5 w-5"/>
        <span class="ml-2 text-sm">Joined {{ $profile->joined_date }}</span>
    </div>
</div>