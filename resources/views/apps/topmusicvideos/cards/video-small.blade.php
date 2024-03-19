<?php
    $params = [
        'slug' => $video->slug,
    ];

    if(isset($object_type) && isset($id)) {
        $params['type'] = $object_type;
        $params['id'] = $id;       
    }

?>
<a href="{{ route($app.'.video.show', $params) }}" class="playlist-item block image-hover" data-ytid="{{ $video->ytid }}" data-slug="{{ $video->slug }}">
    <div class="w-full lg:flex">
        <!-- Image -->    
        <div class="aspect-video w-full lg:w-32 flex-none bg-cover rounded-t lg:rounded-t-none text-center overflow-hidden img-container">
            <img class="w-full" src="{{ $video->thumbnail }}" alt="" />
        </div>
        <!-- Info --> 
        <div class="w-full border-r border-b border-l border-gray-200 lg:border-l-0 lg:border-t bg-white rounded-b lg:rounded-b-none p-4 lg:p-0 lg:pl-4 flex flex-col items-center justify-center lg:items-start leading-normal truncate">
            <div class="text-gray-900 font-bold text-lg truncate">
                {{ $video->name }}
            </div>
            <p class="text-gray-700 text-base truncate">
                {{ $video->artist->name }}
            </p>
        </div>
    </div>
</a>
