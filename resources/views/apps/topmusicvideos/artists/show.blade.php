@extends('apps.'.$app.'._layout')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight truncate">
        {{ $artist->name }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            @livewire('videos.video-list', [
                'app' => $app,
                'object' => $artist,
                'object_type' => 'artist'
            ])
        </div>
    </div>
@endsection
