<a href="{{ route($app.'.members.show', $profile->name) }}" class="image-hover">
    <div class="w-full lg:flex">
        <!-- Image -->    
        <div class="w-full lg:h-24 lg:w-32 flex-none bg-cover rounded-t lg:rounded-t-none text-center overflow-hidden img-container">
            <img class="w-full" src="{{ $profile->avatar_thumb }}" alt="" />
        </div>
        <!-- Info --> 
        <div class="w-full border-r border-b border-l border-gray-200 lg:border-l-0 lg:border-t bg-white rounded-b lg:rounded-b-none p-4 lg:p-0 lg:pl-4 flex flex-col items-center justify-center lg:items-start leading-normal">
            <div class="text-gray-900 font-bold text-lg truncate">
                {{ $profile->name }}
                @livewire('user.user-online', ['userId' => $profile->id])
            </div>
            <!--<p class="text-gray-700 text-base truncate">
                {{ $profile->name }}
            </p>-->
        </div>
    </div>
</a>
