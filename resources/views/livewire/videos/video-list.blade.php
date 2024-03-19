<div>
    <div class="px-10 flex flex-col justify-center w-full sm:grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @foreach ($items as $item) 
            @switch($object_type)
                @case("list")
                    @include('apps.'.$app.'.cards.video',[
                        'video' => $item->object,
                        'id' => $item->list_id
                    ])
                @break
                @case("category")
                    @include('apps.'.$app.'.cards.video',[
                        'video' => $item,
                        'id' => $object->id
                    ])
                @break
                @case("artist")
                    @include('apps.'.$app.'.cards.video',[
                        'video' => $item,
                        'id' => $object->id
                    ])
                @break
                @default
                    @include('apps.'.$app.'.cards.video',[
                        'video' => $item
                    ])
                @break
            @endswitch
        @endforeach
    </div>

    @if($this->hasMorePages())
        @include('components.load-more')
    @endif
</div>
