<a href="{{ route($app.'.categories.show', $category->slug) }}" class="image-hover">
    <div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">                        
        <!-- Image -->  
        <div class="img-container rounded-t-lg overflow-hidden aspect-video">
            <img class="w-full" src="{{ $category->thumbnail }}" alt="" />  
        </div>
        <!-- Info -->
        <div class="p-4"> 
            <h5 class="mb-2 text-xl font-bold tracking-tight text-center text-gray-900 dark:text-white truncate">
                {{ $category->name }}
            </h5> 
            <p class="text-gray-700 text-base text-center truncate">
                {{ $category->videos_count }} 
                @if ($category->videos_count > 1)
                    Videos
                @else
                    Video
                @endif
            </p>
        </div>
    </div>
</a>
