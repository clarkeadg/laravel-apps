<div class="mb-4 aspect-16x9">
    @isset($top)
        <div class="hero-slider hidden aspect-video">
            @foreach ($top['videos'] as $video)
                @include('apps.'.$app.'.cards.hero')
            @endforeach
        </div>
    @endif
</div>