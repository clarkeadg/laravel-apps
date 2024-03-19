@extends('apps.'.$app.'._layout')

@section('content')
    <div class="max-w-7xl mx-auto">
        @auth
            <div class="p-4 bg-white border border-gray-300 rounded-lg mb-4">            
                @livewire('tweets.tweet-create', [
                    'app' => $app
                ])            
            </div>
        @endauth

        @livewire('tweets.tweet-list', [
            'app' => $app,
            'name' => 'feed'
        ])
    </div>    
@endsection
