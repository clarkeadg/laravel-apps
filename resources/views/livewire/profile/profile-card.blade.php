<a href="{{ route($app.'.members.show', $profile->name) }}" class="block">
    <div class="border border-gray-200 rounded-lg">
        <div class="block h-28 rounded-t-lg" style="background: url({{ $profile->cover_photo }}) no-repeat center top / 100% auto;">
            &nbsp;
        </div>
        <div class="flex w-full px-3 py-2"> 
            <div class="inline-block img-container overflow-hidden">    
                <img class="w-12 h-12 rounded-full object-cover" src="{{ $profile->avatar }}" alt="{{ $profile->name }}" />
            </div>
            <div class="ml-4 flex flex-col justify-center items-start leading-normal">
                <div class="text-gray-900 font-bold truncate">
                    {{ $profile->twitter_display_name }}
                </div>
                <p class="text-gray-500">
                    {{ "@".$profile->name }}
                </p>
            </div>
        </div>
    </div>
</a>
