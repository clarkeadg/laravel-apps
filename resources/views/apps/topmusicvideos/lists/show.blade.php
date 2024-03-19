@extends('apps.'.$app.'._layout')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('List') }} - {{ $list->name }}
    </h2>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto"> 
        <div class="py-12">
            @livewire('videos.video-list', [
                'app' => $app,
                'object' => $list,
                'object_type' => 'list'
            ])
        </div>
    </div>
@endsection
