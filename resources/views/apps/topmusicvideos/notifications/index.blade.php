@extends('apps.'.$app.'._layout')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Notifications') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="py-6 px-10">
            @livewire('notifications.notifications-list', [
                'app' => $app
            ])
        </div>
    </div>
@endsection
