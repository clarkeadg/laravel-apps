@extends('apps.'.$app.'._layout')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Blocks') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto">
        
        <div class="p-4 bg-white rounded-lg border border-gray-300">
            <div class="flex items-center mb-2">
                <x-heroicon-o-no-symbol class="h-6 w-6"/> 
                <span class="ml-2 font-bold text-lg">{{ __('Blocks') }}</span>            
            </div>

            @livewire('reactions.reactions-list', [
                'app' => $app,
                'name' => 'block',
                'object_type' => 'App\Models\User',
            ])
        </div>
    </div>
@endsection
