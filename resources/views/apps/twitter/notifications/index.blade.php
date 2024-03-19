@extends('apps.'.$app.'._layout')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Notifications') }}
    </h2>
@endsection

@section('content')
    <div class="">
        @livewire('notifications.notifications-list', [
            'app' => $app
        ])
    </div>
@endsection
