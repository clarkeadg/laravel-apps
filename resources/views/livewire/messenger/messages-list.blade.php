<div>
    @foreach ($items as $thread)
        @if($view == "sent")
            @include('apps.'.$app.'.messages._thread_sent')
        @else
            @include('apps.'.$app.'.messages._thread')
        @endif                
    @endforeach

    @if($this->hasMorePages())
        @include('components.load-more')
    @endif
</div>
