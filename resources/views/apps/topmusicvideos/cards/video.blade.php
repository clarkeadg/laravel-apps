<?php
    $params = [
        'slug' => $video->slug,
    ];

    if(isset($object_type) && isset($id)) {
        $params['type'] = $object_type;
        $params['id'] = $id;       
    }

?>
<a href="{{ route($app.'.video.show', $params) }}" class="image-hover">
    <div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">                        
        <!-- Image --> 
        <div class="img-container rounded-t-lg overflow-hidden aspect-video">
            <img class="w-full" src="{{ $video->thumbnail }}" alt="" />  
        </div>
        <!-- Info -->
        <div class="p-4"> 
            <h5 class="mb-2 text-xl font-bold tracking-tight text-center text-gray-900 dark:text-white truncate">
                {{ $video->name }}
            </h5>
            <p class="text-gray-700 text-base text-center truncate">
                {{ $video->artist->name }}
            </p> 
        </div>
    </div>
</a>
