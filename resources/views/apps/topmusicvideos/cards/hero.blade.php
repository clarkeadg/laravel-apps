<a href="{{ route($app.'.video.show', $video->slug) }}" class="image-hover">
    <div class="relative">                        
        <!-- Image --> 
        <div class="img-container overflow-hidden aspect-video">
            <img class="w-full -mt-28" src="{{ $video->image }}" alt="" />  
        </div>
        <!-- Info -->
        <div class="p-10 absolute bottom-0 right-0 bg-black rounded-lg w-1/2 lg:w-1/3 mr-10 mb-10 opacity-80"> 
            <h5 class="mb-2 text-2xl sm:text-4xl font-bold tracking-tight text-center text-white truncate">
                {{ $video->name }}
            </h5>
            <p class="text-lg sm:text-xl text-gray-700 text-white text-center truncate">
                {{ $video->artist->name }}
            </p> 
        </div>
    </div>
</a>
