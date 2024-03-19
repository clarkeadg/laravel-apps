<div class="flex items-center justify-between gap-2">
    <a href="{{ route($app.'.members.show', $profile->name) }}" class="grow bg-white rounded-lg hover:bg-gray-200 hover:cursor-pointer px-4 py-2">
        <div class="flex w-full">
            <!-- Image -->    
            <div class="inline-block img-container overflow-hidden">    
                <img class="w-12 h-12 rounded-full object-cover" src="{{ $profile->avatar }}" alt="{{ $profile->name }}" />
            </div>
            <!-- Info --> 
            <div class="ml-4 flex flex-col justify-center items-start leading-normal">
                <div class="text-gray-900 font-bold text-lg truncate">
                    {{ $profile->twitter_display_name }}
                </div>
                <p class="text-gray-500">
                    {{ "@".$profile->name }}
                </p>
            </div>
        </div>
    </a>
    <div class="flex gap-2">  
        @livewire('reactions.reactions-button', [
            'name' => 'follow',
            'icon' => 'heart',
            'title' => 'Follow',
            'activeTitle' => 'Following',
            'object_type' => 'App\Models\User',
            'object_id' => $profile->id
        ], key('profile-search-reaction-'.$profile->id))                  
    </div>
</div>
