@extends('apps.'.$app.'._layout')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Bookmarks') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center mb-2">
            <x-heroicon-o-bookmark-square class="h-6 w-6"/> 
            <span class="ml-2 font-bold text-lg">{{ __('Bookmarks') }}</span>            
        </div>

        @livewire('reactions.reactions-list', [
            'app' => $app,
            'name' => 'bookmark',
            'object_type' => 'App\Models\Tweet',
        ])
    </div>
@endsection
