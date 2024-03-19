<div>
    @if ($object_type == "App\Models\Video")
        <div class="flex flex-col justify-center w-full sm:grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach ($items as $activity)                
                @include('apps.'.$app.'.cards.video', [
                    'video' => $activity->object
                ])                
            @endforeach
        </div>
    @endif

    @if ($object_type == "App\Models\User")
        <div class="flex flex-col justify-center w-full sm grid-cols-1 gap-2">
            @foreach ($items as $activity) 
                @if($view == "me")
                    @include('apps.'.$app.'.cards.profile', [
                        'profile' => $activity->user
                    ])
                @else
                    @include('apps.'.$app.'.cards.profile', [
                        'profile' => $activity->object
                    ])
                @endif
            @endforeach
        </div>
    @endif

    @if($this->hasMorePages())
        @include('components.load-more')
    @endif
</div>
