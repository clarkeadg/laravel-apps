@extends('apps.'.$app.'._layout')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Messages') }}
    </h2>
@endsection

@section('content')
<div class="max-w-7xl mx-auto">
        @relativeInclude('_navigation')

        <div class="bg-white p-6 border border-gray-300 border-t-0">
            @livewire('messenger.messages-thread', [
                'app' => $app,
                'threadId' => $threadId
            ])
        </div>
    </div>
@endsection
