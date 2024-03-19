@extends('apps.'.$app.'._layout')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center">
            <a href="{{ route($app.'.home') }}">
                <x-heroicon-o-arrow-left class="h-6 w-6"/>
            </a>
            <span class="ml-2 font-bold text-lg">{{ "#".$id }}</span>
        </div>
    
        <div class="pt-4">
            @livewire('tweets.tweet-list', [
                'app' => $app,
                'name' => 'tag',
                'object_type' => $id
            ])
        </div>
    </div>    
@endsection
