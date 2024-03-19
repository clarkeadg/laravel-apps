@extends('apps.'.$app.'._layout')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight truncate">
        {{ $video->name }} - <a href="{{ route($app.'.artists.show', $video->artist->slug) }}" class="text-blue-400 hover:text-blue-600" >{{ $video->artist->name }}</a>
    </h2>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="lg:flex w-full gap-3">
            @relativeInclude('_video')
            @relativeInclude('_playlist')             
        </div>            
    </div>
@endsection
