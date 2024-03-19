@extends('apps.'.$app.'._layout')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Lists') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto">        
        <div class="p-4 bg-white rounded-lg border border-gray-300">
            <div class="flex items-center mb-4">
                <x-heroicon-o-list-bullet class="h-6 w-6"/> 
                <span class="ml-2 font-bold text-lg">{{ __('Lists') }}</span>            
            </div>

            @livewire('lists.list-create', [
                'app' => $app,
                'type' => 'videos',
            ])
        </div>
    </div>
@endsection
