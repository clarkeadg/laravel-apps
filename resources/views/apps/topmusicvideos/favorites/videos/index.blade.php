@extends('apps.'.$app.'._layout')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight truncate">
        {{ __('Favorites') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="py-6 px-10">
            @livewire('reactions.reactions-list', [
                'app' => $app,
                'name' => 'favorite',
                'object_type' => 'App\Models\Video',
            ])
        </div>
    </div>
@endsection
