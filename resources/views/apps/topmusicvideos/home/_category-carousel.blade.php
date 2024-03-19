<div class="px-7">
    <div class="category-slider hidden px-10 relative">
        @foreach ($category['videos'] as $video)
            <div class="px-2">
                @include('apps.'.$app.'.cards.video',[
                    'object_type' => 'category',
                    'id' => $category['id']
                ])
            </div>
        @endforeach
    </div>
</div>