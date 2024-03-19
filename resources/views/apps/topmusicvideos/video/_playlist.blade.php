<div class="lg:block w-full lg:w-2/6 mb-5">
    <div class="p-2 text-center lg:text-right mb-4 lg:mb-0">
        <span class="">
            Category - 
        </span>
        <a href="{{ route($app.'.categories.show', $category->slug) }}" class="text-lg text-blue-400 hover:text-blue-600" >
            {{ $category->name }}
        </a>
    </div>          
    <div class="w-full grid grid-cols-2 lg:grid-cols-1 gap-4 lg:gap-1 px-2 lg:px-0">                        
        @foreach ($playlist as $video)
            @include('apps.'.$app.'.cards.video-small')
        @endforeach
    </div>
</div> 