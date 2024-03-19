<div>
    <button class="image-hover w-full bg-white" wire:click="readNotification({{ $item->id }})">
        <div class="w-full lg:flex">
            <!-- Image -->    
            <div class="w-full @if($size == 'small') lg:h-12 lg:w-16 @else lg:h-24 lg:w-32 @endif flex-none bg-cover rounded-t lg:rounded-t-none text-center overflow-hidden img-container">
                <img class="w-full" src="{{ $item->object->avatar_thumb }}" alt="" />
            </div>
            <!-- Info --> 
            <div class="w-full border-r border-b border-l border-gray-200 lg:border-l-0 lg:border-t rounded-b lg:rounded-b-none p-4 lg:p-0 lg:pl-4 flex flex-col items-center justify-center lg:items-start leading-normal @if($item->read) bg-white @else bg-gray-300 @endif">
                <div class="text-gray-900 font-bold text-lg truncate">
                    {{ $item->object->name }}
                </div>
                <p class="text-gray-700 text-base truncate">
                    {{ renderNotificationName($item->name) }}
                </p>
            </div>
        </div>
    </button>
</div>
