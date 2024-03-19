<div>
    <div class="px-10 flex flex-col justify-center w-full sm:grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @foreach ($items as $artist) 
            @include('apps.'.$app.'.cards.artist')
        @endforeach
    </div>

    @if($this->hasMorePages())
        @include('components.load-more')
    @endif
</div>
