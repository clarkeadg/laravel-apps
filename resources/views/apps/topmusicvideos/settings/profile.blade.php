@extends('apps.'.$app.'._layout')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Profile') }}
    </h2>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto sm:py-6">
        @relativeInclude('_navigation')

        <div class="bg-white p-6 border border-gray-300 border-t-0">
            @livewire('profile.profile-edit', [
                'group' => 'The Essentials',
                'columns' => 2
            ])
            
            @livewire('profile.profile-edit', [
                'group' => 'The Basics',
                'columns' => 2
            ])

            @livewire('profile.profile-edit', [
                'group' => 'About',
                'columns' => 2
            ])

            @livewire('profile.profile-edit', [
                'group' => 'Description',
                'columns' => 1
            ])
        </div>
    </div>
@endsection
