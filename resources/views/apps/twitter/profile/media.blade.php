@extends('apps.'.$app.'._layout')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg border border-gray-300">    
            @relativeInclude('_header')
            <div class="p-4">
                @relativeInclude('_navigation')
                @livewire('tweets.tweet-list', [
                    'app' => $app,
                    'name' => 'profile_media',
                    'object_id' => $profile->id
                ])
            </div>
        </div>  
    </div>
@endsection
