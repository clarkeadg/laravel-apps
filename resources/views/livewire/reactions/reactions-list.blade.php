<div>
    @if ($object_type == "App\Models\Video")
        <div class="flex flex-col justify-center w-full sm:grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach ($items as $reaction)
                @include('apps.'.$app.'.cards.video', [
                    'video' => $reaction->object,
                    'object_type' => 'favorite',
                    'id' => $reaction->object->id
                ])                
            @endforeach
        </div>
    @endif

    @if ($object_type == "App\Models\User")
        @switch($name)
            @case("block")
                <div class="flex flex-col justify-center w-full grid grid-cols-1 gap-2">
                    @foreach ($items as $reaction) 
                        @include('apps.'.$app.'.cards.profile-blocked', [
                            'profile' => $reaction->object
                        ])
                    @endforeach
                </div>
            @break
            @case("mute")
                <div class="flex flex-col justify-center w-full grid grid-cols-1 gap-2">
                    @foreach ($items as $reaction) 
                        @include('apps.'.$app.'.cards.profile-muted', [
                            'profile' => $reaction->object
                        ])
                    @endforeach
                </div>
            @break
            @default
                <div class="flex flex-col justify-center w-full grid grid-cols-1 gap-2">
                    @foreach ($items as $reaction) 
                        @if($view == "me")
                            @include('apps.'.$app.'.cards.profile', [
                                'profile' => $reaction->user
                            ])
                        @else
                            @include('apps.'.$app.'.cards.profile', [
                                'profile' => $reaction->object
                            ])
                        @endif
                    @endforeach
                </div>
        @endswitch
    @endif

    @if ($object_type == "App\Models\Tweet")
        <div class="flex flex-col justify-center w-full grid grid-cols-1 gap-2">
            @foreach ($items as $reaction) 
                @livewire('tweets.tweet-item', [
                    'app' => $app,
                    'item' => $reaction->object
                ])
            @endforeach
        </div>
    @endif     

    @if($this->hasMorePages())
        @include('components.load-more')
    @endif
</div>
