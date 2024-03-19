@extends('apps.'.$app.'._layout')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center mb-4">
            <a href="{{ route($app.'.home') }}">
                <x-heroicon-o-arrow-left class="h-6 w-6"/>
            </a>
            <span class="ml-2 font-bold text-lg">{{ "@".$tweet->user->name."'s post" }}</span>
        </div>

        <div class="bg-white rounded-lg border border-gray-300">
            <div class="p-4">
                <div class="mb-4">
                    @livewire('tweets.tweet-item', [
                        'app' => $app,
                        'item' => $tweet,
                    ])
                </div>
                @livewire('tweets.tweet-list', [
                    'app' => $app,
                    'name' => 'comments',
                    'object_id' => $id
                ])
            </div>
        </div>
    </div>
@endsection
