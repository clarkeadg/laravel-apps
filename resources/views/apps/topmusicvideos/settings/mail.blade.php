@extends('apps.'.$app.'._layout')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Mail Settings') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto sm:py-6">
        @relativeInclude('_navigation')

        <div class="bg-white p-6 border border-gray-300 border-t-0">
            @livewire('user.user-meta-edit')
        </div>
    </div>
@endsection