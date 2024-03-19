@extends('apps.'.$app.'._layout')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Profile') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto">

        <div class="p-4 bg-white rounded-lg border border-gray-300">
            <div class="flex items-center">
                <a href="{{ route($app.'.settings') }}">
                    <x-heroicon-o-arrow-left class="h-6 w-6"/>
                </a>
                <span class="ml-2 font-bold text-lg">{{ __('Edit Profile') }}</span>
            </div>  

            @livewire('profile.profile-edit', [
                'group' => 'TwitterProfile',
                'columns' => 1,
                'hideTitle' => true
            ])

            <div class="grid grid-cols-2 gap-4">
                @livewire('profile.profile-card',[
                    'app' => $app
                ])

                <div class="">
                    <div class="mb-4">
                        @livewire('profile.profile-photo-upload',[
                            'app' => $app
                        ], key('profile-photo-upload-cover'))
                    </div>                    
                </div>
            </div>
        </div>
    </div>
@endsection
