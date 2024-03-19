<div>
    @foreach ($items as $tag)   
        <a href="{{ route($app.'.tag', $tag->name) }}" class="ml-2 text-sm text-gray-500 hover:underline">
            {{ "#".$tag->name }}
        </a>
    @endforeach
</div>
