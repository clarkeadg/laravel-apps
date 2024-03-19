@extends('apps.'.$app.'._layout')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Messages') }}
    </h2>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
        <div class="bg-white p-6 border border-gray-300">
            @livewire('messenger.messages-create', [
                'app' => $app,
                'name' => $name
            ])
        </div>
    </div>
@endsection
