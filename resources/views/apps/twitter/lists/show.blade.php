@extends('apps.'.$app.'._layout')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('List') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto"> 
        @livewire('tweets.tweet-list', [
            'app' => $app,
            'name' => 'list',
            'object_id' => $id,
            'icon' => 'list-bullet'
        ])
    </div>
@endsection
