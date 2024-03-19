@extends('apps.'.$app.'._layout')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Delete Account') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto">
        
        <div class="p-4 bg-white rounded-lg border border-gray-300">
            <div class="flex items-center">
                <a href="{{ route($app.'.settings') }}">
                    <x-heroicon-o-arrow-left class="h-6 w-6"/>
                </a>
                <span class="ml-2 font-bold text-lg">{{ __('Delete Account') }}</span>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <div class="py-2">
                    <div class="mt-10 sm:mt-0">
                        @livewire('profile.delete-user-form')
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
